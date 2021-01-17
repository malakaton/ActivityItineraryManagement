<?php

declare(strict_types=1);

namespace Academy\Itinerary\Domain;

interface ItineraryRepository
{
    public function search(ItineraryUuid $itineraryUuid): ?Itinerary;
}