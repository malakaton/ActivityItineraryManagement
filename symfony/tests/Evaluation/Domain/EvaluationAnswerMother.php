<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Tests\Shared\Domain\StringMother;

final class EvaluationAnswerMother
{
    public static function create(string $value): EvaluationAnswer
    {
        return new EvaluationAnswer($value);
    }

    public static function random(): EvaluationAnswer
    {
        return self::create(StringMother::random());
    }
}