<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Domain;

use Academy\Activity\Domain\ActivityUuid;

final class ActivityUuidMother
{
    public const stub_uuid = '70f066f6-1cb7-4c45-97e2-287f0258ba02';

    public static function create(string $value): ActivityUuid
    {
        return new ActivityUuid($value);
    }

    public static function random(): ActivityUuid
    {
        return self::create(UuidMother::random());
    }
}