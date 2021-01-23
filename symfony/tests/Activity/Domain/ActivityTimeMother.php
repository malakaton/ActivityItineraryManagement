<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\ActivityId;
use Academy\Activity\Domain\ActivityTime;
use Academy\Tests\Shared\Domain\IntMother;

final class ActivityTimeMother
{
    public static function create(int $value): ActivityTime
    {
        return new ActivityTime($value);
    }

    public static function random(): ActivityTime
    {
        return self::create(IntMother::random());
    }

    public static function getByActivityId(ActivityId $id): ActivityTime
    {
        $time = [
            'A1' => 120,
            'A2' => 60,
            'A3' => 1_0,
            'A4' => 120,
            'A5' => 180,
            'A6' => 120,
            'A7' => 120,
            'A8' => 120,
            'A9' => 120,
            'A10' => 120,
            'A11' => 120,
            'A12' => 120,
            'A13' => 120,
            'A14' => 120,
            'A15' => 120
        ];

        return self::create($time[$id->value()]);
    }
}