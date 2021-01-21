<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Evaluation\Domain\EvaluationPercentageInvertedTime;
use Academy\Tests\Shared\Domain\IntMother;

final class EvaluationPercentageInvertedTimeMother
{
    public static function create(int $value): EvaluationPercentageInvertedTime
    {
        return new EvaluationPercentageInvertedTime($value);
    }

    public static function random(): EvaluationPercentageInvertedTime
    {
        return self::create(IntMother::random());
    }
}