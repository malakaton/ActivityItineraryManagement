<?php

declare(strict_types=1);

namespace Academy\Activity\Infrastructure\Persistence\Doctrine;

use Academy\Activity\Domain\ActivityUuid;
use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ActivityUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return ActivityUuid::class;
    }
}