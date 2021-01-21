<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Domain;

use Academy\Student\Domain\StudentUuid;

final class StudentUuidMother
{
    public const stub_uuid = '70f066f6-1cb7-4c45-97e2-287f0258ba02';

    public static function create(string $value): StudentUuid
    {
        return new StudentUuid($value);
    }

    public static function random(): StudentUuid
    {
        return self::create(UuidMother::random());
    }
}