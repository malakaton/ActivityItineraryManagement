<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Activity\Domain\ActivityLevel;
use Academy\Activity\Domain\ActivityId;
use Academy\Itinerary\Domain\ItineraryUuid;

interface ActivityItineraryRepository
{
    public function searchActivitiesByItineraryUuid(ItineraryUuid $itineraryUuid): ?array;
    public function getFirstActivityItineraryByLevel(
        ItineraryUuid $itineraryUuid,
        ActivityLevel $activityLevel
    ): ?array;
    public function getActivityItineraryByCriteria(
        ItineraryUuid $itineraryUuid,
        ActivityItineraryPosition $activityPosition,
        ActivityLevel $activityLevel = null
    ): ?array;
    public function getNextPositionByItineraryUuid(ItineraryUuid $itineraryUuid): ActivityItineraryPosition;
    public function isDuplicatedActivity(ItineraryUuid $itineraryUuid, ActivityId $activityId): bool;
    public function save(ActivityItinerary $activityItinerary): void;
}