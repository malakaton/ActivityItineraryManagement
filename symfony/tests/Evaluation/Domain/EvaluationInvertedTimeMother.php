<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Evaluation\Domain\EvaluationInvertedTime;
use Academy\Tests\Shared\Domain\IntMother;

final class EvaluationInvertedTimeMother
{
    public static function create(int $value): EvaluationInvertedTime
    {
        return new EvaluationInvertedTime($value);
    }

    public static function random(): EvaluationInvertedTime
    {
        return self::create(IntMother::random());
    }
}