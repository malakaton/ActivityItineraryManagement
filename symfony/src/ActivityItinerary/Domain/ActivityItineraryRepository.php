<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain;

use Academy\Itinerary\Domain\ItineraryUuid;

interface ActivityItineraryRepository
{
    public function searchByItineraryUuid(ItineraryUuid $itineraryUuid): ?ActivityItinerary;
    public function getNextPositionByItineraryUuid(ItineraryUuid $itineraryUuid): ActivityItineraryPosition;
    public function save(ActivityItinerary $activityItinerary): void;
}