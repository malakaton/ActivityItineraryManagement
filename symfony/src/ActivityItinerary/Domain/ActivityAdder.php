<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
use Academy\Activity\Domain\Exception\ActivityNotFound;
use Academy\Itinerary\Domain\Exception\ItineraryNotFound;
use Academy\Itinerary\Domain\ItineraryRepository;
use Academy\Itinerary\Domain\ItineraryUuid;
use Psr\Log\LoggerInterface;

final class ActivityAdder
{
    private ItineraryRepository $itineraryRepository;
    private ActivityRepository $activityRepository;
    private ActivityItineraryRepository $activityItineraryRepository;
    private LoggerInterface $logger;

    public function __construct(
        ItineraryRepository $itineraryRepository,
        ActivityRepository $activityRepository,
        ActivityItineraryRepository $activityItineraryRepository,
        LoggerInterface $logger
    ) {
        $this->itineraryRepository = $itineraryRepository;
        $this->activityRepository = $activityRepository;
        $this->activityItineraryRepository = $activityItineraryRepository;
        $this->logger = $logger;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityName $activityName
     * @return string
     * @throws ActivityNotFound
     * @throws ItineraryNotFound
     */
    public function __invoke(
        ItineraryUuid $itineraryUuid,
        ActivityName $activityName
    ): string
    {
        $this->guardItineraryUuid($itineraryUuid);
        $activity = $this->guardActivityName($activityName);

        $activityItinerary = ActivityItinerary::add(
            $itineraryUuid,
            $activity->uuid(),
            $this->activityItineraryRepository->getNextPositionByItineraryUuid($itineraryUuid)
        );

        $this->activityItineraryRepository->save($activityItinerary);

        $message = "Activity name: {$activityName->value()} added to itinerary uuid: {$itineraryUuid->value()} successfully";

        $this->logger->info($message);

        return $message;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @throws ItineraryNotFound
     */
    private function guardItineraryUuid(ItineraryUuid $itineraryUuid): void
    {
        if (!$this->itineraryRepository->search($itineraryUuid)) {
            $this->logger->alert("Itinerary with uuid: {$itineraryUuid->value()} not found");
            throw new ItineraryNotFound($itineraryUuid->value());
        }
    }

    /**
     * @param ActivityName $activityName
     * @return Activity|null
     * @throws ActivityNotFound
     */
    private function guardActivityName(ActivityName $activityName): ?Activity
    {
        if (!$activity = $this->activityRepository->searchByName($activityName)) {
            $this->logger->alert("Activity with name: {$activityName->value()} not found");
            throw new ActivityNotFound($activityName->value());
        }

        return $activity;
    }
}