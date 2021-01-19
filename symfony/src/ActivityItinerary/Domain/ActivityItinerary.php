<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Activity\Domain\ActivityUuid;
use Academy\Itinerary\Domain\ItineraryUuid;

final class ActivityItinerary
{
    private ActivityItineraryUuid $uuid;
    private ItineraryUuid $itineraryUuid;
    private ActivityUuid $activityUuid;
    private ActivityItineraryPosition $position;

    public function __construct(
        ActivityItineraryUuid $uuid,
        ItineraryUuid $itineraryUuid,
        ActivityUuid $activityUuid,
        ActivityItineraryPosition $position
    )
    {
        $this->uuid = $uuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->activityUuid = $activityUuid;
        $this->position = $position;
    }

    public static function create(
        ItineraryUuid $itineraryUuid,
        ActivityUuid $activityUuid,
        ActivityItineraryPosition $position
    ): ActivityItinerary
    {
        return new self(ActivityItineraryUuid::random(), $itineraryUuid, $activityUuid, $position);
    }

    public function uuid(): ActivityItineraryUuid
    {
        return $this->uuid;
    }

    public function itineraryUuid(): ItineraryUuid
    {
        return $this->itineraryUuid;
    }

    public function activityUuid(): ActivityUuid
    {
        return $this->activityUuid;
    }

    public function position(): ActivityItineraryPosition
    {
        return $this->position;
    }
}