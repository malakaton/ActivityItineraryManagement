<?php

declare(strict_types=1);

namespace Academy\Itinerary\Domain;

interface IItineraryGuard
{
    public function guard(ItineraryUuid $itineraryUuid): void;
}