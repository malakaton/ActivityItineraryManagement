<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\IActivityGuard;
use Academy\ActivityItinerary\Domain\Exception\DuplicatedActivity;
use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Psr\Log\LoggerInterface;

final class ActivityAdder
{
    private IItineraryGuard $itineraryGuard;
    private IActivityGuard $activityGuard;
    private ActivityItineraryRepository $activityItineraryRepository;
    private LoggerInterface $logger;

    public function __construct(
        IItineraryGuard $itineraryGuard,
        IActivityGuard $activityGuard,
        ActivityItineraryRepository $activityItineraryRepository,
        LoggerInterface $logger
    ) {
        $this->itineraryGuard = $itineraryGuard;
        $this->activityGuard = $activityGuard;
        $this->activityItineraryRepository = $activityItineraryRepository;
        $this->logger = $logger;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityName $activityName
     * @return string
     * @throws DuplicatedActivity
     */
    public function __invoke(
        ItineraryUuid $itineraryUuid,
        ActivityName $activityName
    ): string
    {
        $this->itineraryGuard->guard($itineraryUuid);
        $this->activityGuard->guard($activityName);
        $this->guardDuplicateActivity($itineraryUuid, $this->activityGuard->getActivity());

        $activityItinerary = ActivityItinerary::add(
            $itineraryUuid,
            $this->activityGuard->getActivity()->uuid(),
            $this->activityItineraryRepository->getNextPositionByItineraryUuid($itineraryUuid)
        );

        $this->activityItineraryRepository->save($activityItinerary);

        $message = "Activity name: {$activityName->value()} added to itinerary uuid: {$itineraryUuid->value()} successfully";

        $this->logger->info($message);

        return $message;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param Activity $activity
     * @return Activity|null
     * @throws DuplicatedActivity
     */
    private function guardDuplicateActivity(ItineraryUuid $itineraryUuid, Activity $activity): ?Activity
    {
        if ($this->activityItineraryRepository->isDuplicatedActivity($itineraryUuid, $activity->uuid())) {
            $this->logger->alert("Activity with name: {$activity->name()->value()} duplicated on itinerary
                uuid {$itineraryUuid->value()}");
            throw new DuplicatedActivity($itineraryUuid->value(), $activity->name()->value());
        }

        return $activity;
    }
}