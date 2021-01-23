<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\Activity;

interface EvaluationCalculateScoreService
{
    public function calculate(EvaluationAnswer $answer, Activity $activity): int;
}