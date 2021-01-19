<?php

declare(strict_types=1);

namespace Academy\Student\Infrastructure\Persistence\Doctrine;

use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use Academy\Student\Domain\StudentUuid;

final class StudentUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return StudentUuid::class;
    }
}