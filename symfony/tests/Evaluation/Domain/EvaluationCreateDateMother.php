<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Evaluation\Domain\EvaluationCreateDate;
use Academy\Tests\Shared\Domain\DateTimeMother;

final class EvaluationCreateDateMother
{
    public static function create(\DateTime $value): EvaluationCreateDate
    {
        return new EvaluationCreateDate($value);
    }

    public static function random(): EvaluationCreateDate
    {
        return self::create(DateTimeMother::random());
    }
}