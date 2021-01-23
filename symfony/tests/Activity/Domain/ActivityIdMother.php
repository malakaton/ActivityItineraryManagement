<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\ActivityId;
use Academy\Tests\Shared\Domain\UuidMother;

final class ActivityIdMother
{
    public const stub_uuid = 'A1';
    public const FAKE_ACTIVITY_UUID_STUB = 'A99';

    public static function create(string $value): ActivityId
    {
        return new ActivityId($value);
    }

    public static function random(): ActivityId
    {
        return self::create(UuidMother::random());
    }
}