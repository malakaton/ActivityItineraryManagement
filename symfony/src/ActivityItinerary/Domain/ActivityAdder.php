<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Activity\Domain\ActivityId;
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
     * @param ActivityId $activityId
     * @return string
     * @throws DuplicatedActivity
     */
    public function __invoke(
        ItineraryUuid $itineraryUuid,
        ActivityId $activityId
    ): string
    {
        $this->itineraryGuard->guard($itineraryUuid);
        $this->activityGuard->guard($activityId);
        $this->guardDuplicateActivity($itineraryUuid, $activityId);

        $activityItinerary = ActivityItinerary::create(
            $itineraryUuid,
            $activityId,
            $this->activityItineraryRepository->getNextPositionByItineraryUuid($itineraryUuid)
        );

        $this->activityItineraryRepository->save($activityItinerary);

        $message = "Activity id: {$activityId->value()} added to itinerary uuid: {$itineraryUuid->value()} successfully";

        $this->logger->info($message);

        return $message;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityId $activityId
     * @throws DuplicatedActivity
     */
    private function guardDuplicateActivity(ItineraryUuid $itineraryUuid, ActivityId $activityId): void
    {
        if ($this->activityItineraryRepository->isDuplicatedActivity($itineraryUuid, $activityId)) {
            $this->logger->alert("Activity id: {$activityId->value()} duplicated on itinerary
                uuid {$itineraryUuid->value()}");
            throw new DuplicatedActivity($itineraryUuid->value(), $activityId->value());
        }
    }
}