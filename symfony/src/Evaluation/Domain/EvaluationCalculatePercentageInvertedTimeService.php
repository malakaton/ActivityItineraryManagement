<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\ActivityTime;

interface EvaluationCalculatePercentageInvertedTimeService
{
    public function calculate(EvaluationInvertedTime $invertedTime, ActivityTime $time): int;
}