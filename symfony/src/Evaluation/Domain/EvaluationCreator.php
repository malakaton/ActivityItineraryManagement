<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
use Academy\Activity\Domain\IActivityGuard;
use Academy\ActivityItinerary\Domain\Exception\DuplicatedActivity;
use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\IStudentGuard;
use Academy\Student\Domain\StudentUuid;
use Psr\Log\LoggerInterface;

final class EvaluationCreator
{
    private IStudentGuard $studentGuard;
    private IItineraryGuard $itineraryGuard;
    private IActivityGuard $activityGuard;
    private ActivityRepository $activityRepository;
    private EvaluationRepository $evaluationRepository;
    private LoggerInterface $logger;

    public function __construct(
        IStudentGuard $studentGuard,
        IItineraryGuard $itineraryGuard,
        IActivityGuard $activityGuard,
        ActivityRepository $activityRepository,
        EvaluationRepository $evaluationRepository,
        LoggerInterface $logger
    ) {
        $this->studentGuard = $studentGuard;
        $this->itineraryGuard = $itineraryGuard;
        $this->activityGuard = $activityGuard;
        $this->activityRepository = $activityRepository;
        $this->evaluationRepository = $evaluationRepository;
        $this->logger = $logger;
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityName $activityName
     * @param EvaluationAnswer $answer
     * @param EvaluationInvertedTime $invertedTime
     * @return string
     */
    public function __invoke(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityName $activityName,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime
    ): string
    {
        $this->studentGuard->guard($studentUuid);
        $this->itineraryGuard->guard($itineraryUuid);
        $this->activityGuard->guard($activityName);

        $this->getScore($answer);

        $activityItinerary = Evaluation::create(
            $studentUuid,
            $itineraryUuid,
            $this->activityGuard->getActivity()->uuid(),
            $answer,
            $time
        );

        $this->activityItineraryRepository->save($activityItinerary);

        $message = "Activity name: {$activityName->value()} added to itinerary uuid: {$itineraryUuid->value()} successfully";

        $this->logger->info($message);

        return $message;
    }

    private function getScore(EvaluationAnswer $answer)
    {
        $activity = $this->activityRepository->searchByName($this->activityGuard->getActivity()->name());
    }

    private function getScoreInvertedTime()
    {

    }

    private function explodeSolution(): array
    {
        
    }
}