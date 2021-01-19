<?php

declare(strict_types=1);

namespace Academy\Evaluation\Infrastructure\Persistence\Doctrine;

use Academy\Evaluation\Domain\EvaluationUuid;
use Academy\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class EvaluationUuidType extends UuidType
{
    protected function typeClassName(): string
    {
        return EvaluationUuid::class;
    }
}