<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Evaluation\Domain\EvaluationUuid;
use Academy\Tests\Shared\Domain\UuidMother;

final class EvaluationUuidMother
{
    public const stub_uuid = 'b89021c3-8771-36a4-9d7d-5b39109b0ac5';

    public static function create(string $value): EvaluationUuid
    {
        return new EvaluationUuid($value);
    }

    public static function random(): EvaluationUuid
    {
        return self::create(UuidMother::random());
    }
}