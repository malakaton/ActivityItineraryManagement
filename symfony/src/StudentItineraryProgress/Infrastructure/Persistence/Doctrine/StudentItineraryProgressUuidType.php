<?php

declare(strict_types=1);

namespace Academy\StudentItineraryProgress\Infrastructure\Persistence\Doctrine;

use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use Academy\StudentItineraryProgress\Domain\StudentItineraryProgressUuid;

final class StudentItineraryProgressUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return StudentItineraryProgressUuid::class;
    }
}