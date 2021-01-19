<?php

declare(strict_types=1);

namespace Academy\StudentItineraryProgress\Domain;

use Academy\Activity\Domain\ActivityName;
use Academy\ActivityItinerary\Domain\ActivityItineraryRepository;
use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\IStudentGuard;
use Academy\Student\Domain\StudentUuid;
use Psr\Log\LoggerInterface;

final class StudentNextActivity
{
    private ActivityItineraryRepository $activityItineraryRepository;
    private IStudentGuard $studentGuard;
    private IItineraryGuard $itineraryGuard;
    private StudentItineraryProgressRepo $itineraryProgressRepo;
    private LoggerInterface $logger;

    public function __construct(
        ActivityItineraryRepository $activityItineraryRepository,
        IStudentGuard $studentGuard,
        IItineraryGuard $itineraryGuard,
        StudentItineraryProgressRepo $itineraryProgressRepo,
        LoggerInterface $logger
    )
    {
        $this->activityItineraryRepository = $activityItineraryRepository;
        $this->studentGuard = $studentGuard;
        $this->itineraryGuard = $itineraryGuard;
        $this->itineraryProgressRepo = $itineraryProgressRepo;
        $this->logger = $logger;
    }

    public function __invoke(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): ?array
    {
        $this->studentGuard->guard($studentUuid);
        $this->itineraryGuard->guard($itineraryUuid);

        $activityName = $this->obtainNextActivityIfNull(
            $itineraryUuid,
            $this->itineraryProgressRepo->find($itineraryUuid, $studentUuid)
        );

        $this->logger->info("Activity list found for itinerary uuid: {$itineraryUuid->value()}");

        return [
            'activity_name' => $activityName->value()
        ];
    }

    private function obtainNextActivityIfNull(ItineraryUuid $itineraryUuid, ActivityName $activityName): ActivityName
    {
        return empty($activityName->value()) ?
            new ActivityName(
                $this->activityItineraryRepository->searchActivitiesByItineraryUuid($itineraryUuid)[0]['name.value']
            ) : $activityName;
    }
}