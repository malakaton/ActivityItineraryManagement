<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\ActivityId;
use Academy\Activity\Domain\ActivityLevel;
use Academy\Tests\Shared\Domain\IntMother;

final class ActivityLevelMother
{
    public static function create(int $value): ActivityLevel
    {
        return new ActivityLevel($value);
    }

    public static function random(): ActivityLevel
    {
        return self::create(IntMother::random());
    }

    public static function getByActivityId(ActivityId $id): ActivityLevel
    {
        $level = [
            'A1' => 1,
            'A2' => 1,
            'A3' => 1,
            'A4' => 1,
            'A5' => 2,
            'A6' => 2,
            'A7' => 3,
            'A8' => 3,
            'A9' => 4,
            'A10' => 5,
            'A11' => 6,
            'A12' => 7,
            'A13' => 8,
            'A14' => 9,
            'A15' => 10
        ];

        return self::create($level[$id->value()]);
    }
}