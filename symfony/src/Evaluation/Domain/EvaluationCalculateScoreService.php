<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\ActivitySolution;

interface EvaluationCalculateScoreService
{
    public function calculate(EvaluationAnswer $answer, ActivitySolution $activitySolution): int;
}