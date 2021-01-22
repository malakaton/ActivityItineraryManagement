<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

use Academy\Activity\Domain\ActivityLevel;
use Academy\Activity\Domain\ActivityName;
use Academy\ActivityItinerary\Domain\ActivityItineraryPosition;
use Academy\ActivityItinerary\Domain\ActivityItineraryRepository;
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

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @return array|null
     */
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

        if ($nextActivityName->value() === '') {
            return [];
        }

        $this->logger->info("The next activity for the student uuid {$studentUuid->value()} is the activity name {$nextActivityName->value()}");

        return [
            'activity_name' => $nextActivityName->value()
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

        if ($lastEvaluation['score.value'] > self::PERCENTAGE_SCORE_NEXT_ACTIVITY
            && $lastEvaluation['percentageInvertedTime.value'] < self::PERCENTAGE_SCORE_TIME_TO_LEVEL_UP) {
            // level up (level.value + 1) and find in activityItinerary the first activity for this new level
            $lastEvaluation['level.value']++;

            $firstActivityItineraryNextLevel = $this->activityItineraryRepository->getFirstActivityItineraryByLevel(
                $lastEvaluation['itineraryUuid'],
                new ActivityLevel($lastEvaluation['level.value'])
            );

            $lastEvaluation['position.value'] = $firstActivityItineraryNextLevel['position.value'];
        }

        if ($lastEvaluation['score.value'] < self::PERCENTAGE_SCORE_DECREASE_LEVEL &&
            $this->isPreviousActivityLessLevel($lastEvaluation)) {
            // check if the activity of position - 1 from the same itinerary have minor level
            // of the last activity evaluated. If is true, decrease level
            $lastEvaluation['level.value']--;

            $lastActivityItineraryLessLevel = $this->evaluationRepository->getLastStudentActivityEvaluatedByLevel(
                $lastEvaluation['studentUuid'],
                $lastEvaluation['itineraryUuid'],
                new ActivityLevel($lastEvaluation['level.value'])
            );

            $lastEvaluation['position.value'] = $lastActivityItineraryLessLevel['position.value'];
            $lastEvaluation['position.value']++;
        }

        return new ActivityName($this->activityItineraryRepository->getActivityItineraryByCriteria(
            $lastEvaluation['itineraryUuid'],
            new ActivityItineraryPosition($lastEvaluation['position.value'])
        )['name.value'] ?? '');
    }

    private function isPreviousActivityLessLevel(array $lastEvaluation): bool
    {
        $lastEvaluation['position.value'] === 1 ?: $lastEvaluation['position.value']--;

        $previousActivity = $this->evaluationRepository->getStudentActivityEvaluatedByItineraryPosition(
            $lastEvaluation['studentUuid'],
            $lastEvaluation['itineraryUuid'],
            new ActivityItineraryPosition($lastEvaluation['position.value'])
        );

        return $previousActivity['level.value'] < $lastEvaluation['level.value'];
    }

    private function obtainActivityIfNullEvaluation(ItineraryUuid $itineraryUuid): ActivityName
    {
        return new ActivityName(
                $this->activityItineraryRepository->searchActivitiesByItineraryUuid(
                    $itineraryUuid
                )[0]['name.value'] ?? ''
        );
    }
}