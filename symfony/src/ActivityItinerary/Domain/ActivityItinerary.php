<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Activity\Domain\ActivityId;
use Academy\Itinerary\Domain\ItineraryUuid;

final class ActivityItinerary
{
    private ActivityItineraryUuid $uuid;
    private ItineraryUuid $itineraryUuid;
    private ActivityId $activityId;
    private ActivityItineraryPosition $position;

    public function __construct(
        ActivityItineraryUuid $uuid,
        ItineraryUuid $itineraryUuid,
        ActivityId $activityId,
        ActivityItineraryPosition $position
    )
    {
        $this->uuid = $uuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->activityId = $activityId;
        $this->position = $position;
    }

    public static function create(
        ItineraryUuid $itineraryUuid,
        ActivityId $activityId,
        ActivityItineraryPosition $position
    ): ActivityItinerary
    {
        return new self(ActivityItineraryUuid::random(), $itineraryUuid, $activityId, $position);
    }

    public function uuid(): ActivityItineraryUuid
    {
        return $this->uuid;
    }

    public function itineraryUuid(): ItineraryUuid
    {
        return $this->itineraryUuid;
    }

    public function activityId(): ActivityId
    {
        return $this->activityId;
    }

    public function position(): ActivityItineraryPosition
    {
        return $this->position;
    }
}