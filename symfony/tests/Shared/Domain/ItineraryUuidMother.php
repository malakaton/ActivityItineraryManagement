<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Domain;

use Academy\Itinerary\Domain\ItineraryUuid;

final class ItineraryUuidMother
{
    public const stub_uuid = '99f951bf-7d49-4a1a-9152-7bdee1f5ce2e';

    public static function create(string $value): ItineraryUuid
    {
        return new ItineraryUuid($value);
    }

    public static function random(): ItineraryUuid
    {
        return self::create(UuidMother::random());
    }
}