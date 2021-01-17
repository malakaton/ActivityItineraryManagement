<?php

declare(strict_types=1);

namespace Academy\Itinerary\Domain;

final class Itinerary
{
    private ItineraryUuid $uuid;

    public function __construct(
        ItineraryUuid $uuid
    )
    {
        $this->uuid = $uuid;
    }

    public function uuid(): ItineraryUuid
    {
        return $this->uuid;
    }
}