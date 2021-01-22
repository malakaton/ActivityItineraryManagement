<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\ActivityName;
use Academy\Tests\Shared\Domain\StringMother;

final class ActivityNameMother
{
    public const stub_name = 'A1';

    public static function create(string $value): ActivityName
    {
        return new ActivityName($value);
    }

    public static function random(): ActivityName
    {
        return self::create(StringMother::random());
    }
}