<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
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

    public function __invoke(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): ?array
    {
        $this->studentGuard->guard($studentUuid);
        $this->itineraryGuard->guard($itineraryUuid);

        $this->calculateNextActivity(
            $this->evaluationRepository->getLastStudentEvaluation($studentUuid, $itineraryUuid)
        );

        $this->logger->info("Activity list found for itinerary uuid: {$itineraryUuid->value()}");

        return [
            'activity_name' => null
        ];
    }

    private function calculateNextActivity(array $lastEvaluation): Activity
    {
        //scoreInvertedTime.value, position.value, activityUuid

        if ($lastEvaluation['score.value'] > self::PERCENTAGE_SCORE_NEXT_ACTIVITY) {
            // go to next activity (ActivityItinerary position + 1)
        }

        if ($lastEvaluation['score.value'] <= self::PERCENTAGE_SCORE_NEXT_ACTIVITY) {
            // repeat activity return same activity uuid
        }

        if ($lastEvaluation['score.value'] > self::PERCENTAGE_SCORE_NEXT_ACTIVITY
            && $lastEvaluation['scoreInvertedTime.value'] < self::PERCENTAGE_SCORE_TIME_TO_LEVEL_UP) {
            // level up (level.value + 1) and find in activityItinerary the first activity for this new level
        }

        if ($lastEvaluation['score.value'] > self::PERCENTAGE_SCORE_NEXT_ACTIVITY
            && $lastEvaluation['scoreInvertedTime.value'] > self::PERCENTAGE_SCORE_TIME_TO_LEVEL_UP) {
            // same level
        }

        if ($lastEvaluation['score.value'] < self::PERCENTAGE_SCORE_DECREASE_LEVEL &&
            $this->isPreviousActivityLessLevel()) {
            // check if the activity of position - 1 from the same itinerary have minor level
            // of the last activity evaluated. If is true, decrease level
        }
    }

    private function isPreviousActivityLessLevel(): bool
    {

    }

//    private function obtainNextActivityIfNull(ItineraryUuid $itineraryUuid, ActivityName $activityName): ActivityName
//    {
//        return empty($activityName->value()) ?
//            new ActivityName(
//                $this->activityItineraryRepository->searchActivitiesByItineraryUuid($itineraryUuid)[0]['name.value']
//            ) : $activityName;
//    }
}