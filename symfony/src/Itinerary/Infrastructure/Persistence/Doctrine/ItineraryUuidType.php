<?php

declare(strict_types=1);

namespace Academy\Itinerary\Infrastructure\Persistence\Doctrine;

use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ItineraryUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return ItineraryUuid::class;
    }
}