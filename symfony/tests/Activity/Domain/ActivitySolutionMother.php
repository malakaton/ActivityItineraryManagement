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
            'A1' => '{"0":1, "1":0, "2":2}',
            'A2' => '{"0":-2, "1":40, "2":56}',
            'A3' => '{"0":1, "1":0}',
            'A4' => '{"0":1, "1":0, "2":2, "3":-5, "4":9}',
            'A5' => '{"0":1, "1":0, "2":2}',
            'A6' =>	'{"0":1, "1":0, "2":2}',
            'A7' => '{"0":1, "1":-1, "2":"Si", "3":34, "4":-6}',
            'A8' => '{"0":1, "1":2}',
            'A9' => '{"0":1, "1":0, "2":2}',
            'A10' => '{"0":1, "1":0, "2":2}',
            'A11' => '{"0":1, "1":0, "2":2}',
            'A12' => '{"0":1, "1":0, "2":2}',
            'A13' => '{"0":1, "1":0, "2":2}',
            'A14' =>'{"0":1, "1":0, "2":2}',
            'A15' =>'{"0":1, "1":0, "2":2}'
        ];

        return self::create($solutions[$name->value()]);
    }
}