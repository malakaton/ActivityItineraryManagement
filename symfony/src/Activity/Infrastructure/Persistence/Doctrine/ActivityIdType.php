<?php

declare(strict_types=1);

namespace Academy\Activity\Infrastructure\Persistence\Doctrine;

use Academy\Activity\Domain\ActivityId;
use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ActivityIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ActivityId::class;
    }
}
