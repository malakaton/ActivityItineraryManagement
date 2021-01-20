<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

use Academy\Activity\Domain\ActivityLevel;
use Academy\Activity\Domain\ActivityName;
use Academy\ActivityItinerary\Domain\ActivityItinerary;
use Academy\ActivityItinerary\Domain\ActivityItineraryPosition;
use Academy\ActivityItinerary\Domain\ActivityItineraryRepository;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationRepository;
use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Psr\Log\LoggerInterface;

final class StudentNextActivity
{
    private const PERCENTAGE_SCORE_NEXT_ACTIVITY = 75;
    private const PERCENTAGE_SCORE_TIME_TO_LEVEL_UP = 50;
    private const PERCENTAGE_SCORE_DECREASE_LEVEL = 20;

    private ActivityItineraryRepository $activityItineraryRepository;
    private IStudentGuard $studentGuard;
    private IItineraryGuard $itineraryGuard;
    private EvaluationRepository $evaluationRepository;
    private LoggerInterface $logger;

    public function __construct(
        ActivityItineraryRepository $activityItineraryRepository,
        IStudentGuard $studentGuard,
        IItineraryGuard $itineraryGuard,
        EvaluationRepository $evaluationRepository,
        LoggerInterface $logger
    )
    {
        $this->activityItineraryRepository = $activityItineraryRepository;
        $this->studentGuard = $studentGuard;
        $this->itineraryGuard = $itineraryGuard;
        $this->evaluationRepository = $evaluationRepository;
        $this->logger = $logger;
    }

    public function __invoke(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): ?array
    {
        $this->studentGuard->guard($studentUuid);
        $this->itineraryGuard->guard($itineraryUuid);

        $nextActivityName = $this->calculateNextActivity(
            $itineraryUuid,
            $this->evaluationRepository->getLastStudentEvaluation($studentUuid, $itineraryUuid)
        );

        $this->logger->info("Activity list found for itinerary uuid: {$itineraryUuid->value()}");

        return [
            'activity_name' => null
        ];
    }

    private function calculateNextActivity(ItineraryUuid $itineraryUuid, ?array $lastEvaluation): ActivityName
    {
        if (is_null($lastEvaluation)) {
            return $this->obtainActivityIfNullEvaluation($itineraryUuid);
        }

        if ($lastEvaluation['score.value'] >= self::PERCENTAGE_SCORE_NEXT_ACTIVITY) {
            // go to next activity (ActivityItinerary position + 1)
            $lastEvaluation['position.value']++;
        }

        if ($lastEvaluation['score.value'] < self::PERCENTAGE_SCORE_NEXT_ACTIVITY) {
            // repeat activity return same activity uuid (same level and position of ActivityItinerary entity)
        }

        if ($lastEvaluation['score.value'] > self::PERCENTAGE_SCORE_NEXT_ACTIVITY
            && $lastEvaluation['percentageInvertedTime.value'] < self::PERCENTAGE_SCORE_TIME_TO_LEVEL_UP) {
            // level up (level.value + 1) and find in activityItinerary the first activity for this new level

            $firstActivityItineraryNextLevel = $this->activityItineraryRepository->getFirstActivityItineraryByLevel(
                $lastEvaluation['itineraryUuid'],
                new ActivityLevel($lastEvaluation['level.value']++)
            );

            $lastEvaluation['position.value'] = $firstActivityItineraryNextLevel['position.value'];
        }

        if ($lastEvaluation['score.value'] > self::PERCENTAGE_SCORE_NEXT_ACTIVITY
            && $lastEvaluation['percentageInvertedTime.value'] > self::PERCENTAGE_SCORE_TIME_TO_LEVEL_UP) {
            // same level
        }

        if ($lastEvaluation['score.value'] < self::PERCENTAGE_SCORE_DECREASE_LEVEL &&
            $this->isPreviousActivityLessLevel($lastEvaluation)) {
            // check if the activity of position - 1 from the same itinerary have minor level
            // of the last activity evaluated. If is true, decrease level
            $lastActivityItineraryLessLevel = $this->evaluationRepository->getLastStudentActivityEvaluatedByLevel(
                $lastEvaluation['studentUuid'],
                $lastEvaluation['itineraryUuid'],
                new ActivityLevel($lastEvaluation['level.value']--)
            );

            $lastEvaluation['level.value']--;
            $lastEvaluation['position.value'] = $lastActivityItineraryLessLevel['position.value']++;
        }

        return new ActivityName($this->activityItineraryRepository->getActivityItineraryByCriteria(
            $lastEvaluation['itineraryUuid'],
            new ActivityItineraryPosition($lastEvaluation['position.value']),
            new ActivityLevel($lastEvaluation['level.value'])
        )['name.value'] ?? '');
    }

    private function isPreviousActivityLessLevel(array $lastEvaluation): bool
    {
        $previousActivity = $this->activityItineraryRepository->getActivityItineraryByCriteria(
            $lastEvaluation['itineraryUuid'],
            new ActivityItineraryPosition(
                ($lastEvaluation['position.value'] == 1) ? $lastEvaluation['position.value'] :
                    ($lastEvaluation['position.value'] - 1)
            ),
            new ActivityLevel($lastEvaluation['level.value'])
        );

        return $previousActivity['level.value'] < $lastEvaluation['level.value'];
    }

    private function obtainActivityIfNullEvaluation(ItineraryUuid $itineraryUuid): ActivityName
    {
        return new ActivityName(
                $this->activityItineraryRepository->searchActivitiesByItineraryUuid($itineraryUuid)[0]['name.value']
        );
    }
}