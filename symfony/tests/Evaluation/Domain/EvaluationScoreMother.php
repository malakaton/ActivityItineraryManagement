<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Evaluation\Domain\EvaluationScore;
use Academy\Tests\Shared\Domain\IntMother;

final class EvaluationScoreMother
{
    public static function create(int $value): EvaluationScore
    {
        return new EvaluationScore($value);
    }

    public static function random(): EvaluationScore
    {
        return self::create(IntMother::random());
    }
}