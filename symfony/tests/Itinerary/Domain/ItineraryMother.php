<?php

declare(strict_types=1);

namespace Academy\Tests\Itinerary\Domain;

use Academy\Itinerary\Domain\Itinerary;
use Academy\Itinerary\Domain\ItineraryUuid;

final class ItineraryMother
{
    public static function create(
        ItineraryUuid $uuid
    ): Itinerary
    {
        return new Itinerary(
            $uuid
        );
    }

    public static function fromRequest(
        ItineraryUuid $uuid
    ): Itinerary
    {
        return self::create(
            ItineraryUuidMother::create($uuid->value())
        );
    }

    public static function random(): Itinerary
    {
        return self::create(
            ItineraryUuidMother::random()
        );
    }
}