<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\Activity;

interface EvaluationCalculatePercentageInvertedTimeService
{
    public function calculate(EvaluationInvertedTime $invertedTime, Activity $activity): int;
}