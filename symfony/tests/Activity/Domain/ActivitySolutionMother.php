<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivitySolution;
use Academy\Tests\Shared\Domain\StringMother;

final class ActivitySolutionMother
{
    public static function create(string $value): ActivitySolution
    {
        return new ActivitySolution($value);
    }

    public static function random(): ActivitySolution
    {
        return self::create(StringMother::random());
    }

    public static function getByActivityName(ActivityName $name): ActivitySolution
    {
        $solutions = [
            'A1' => '1_0_2',
            'A2' => '-2_40_56',
            'A3' => '1_0',
            'A4' => '1_0_2_-5_9',
            'A5' => '1_0_2',
            'A6' =>	'1_0_2',
            'A7' => '1_-1_\'Si\'_34_-6',
            'A8' => '1_2',
            'A9' => '1_0_2',
            'A10' => '1_0_2',
            'A11' => '1_0_2',
            'A12' => '1_0_2',
            'A13' => '1_0_2',
            'A14' => '1_0_2',
            'A15' => '1_0_2'
        ];

        return self::create($solutions[$name->value()]);
    }
}