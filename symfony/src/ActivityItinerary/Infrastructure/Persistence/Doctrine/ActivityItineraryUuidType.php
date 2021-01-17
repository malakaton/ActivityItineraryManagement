<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Infrastructure\Persistence\Doctrine;

use Academy\ActivityItinerary\Domain\ActivityItineraryUuid;
use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ActivityItineraryUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return ActivityItineraryUuid::class;
    }
}