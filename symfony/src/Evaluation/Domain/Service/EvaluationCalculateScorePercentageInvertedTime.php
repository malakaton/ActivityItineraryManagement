<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain\Service;

use Academy\Activity\Domain\Activity;
use Academy\Evaluation\Domain\EvaluationCalculatePercentageInvertedTimeService;
use Academy\Evaluation\Domain\EvaluationInvertedTime;

final class EvaluationCalculateScorePercentageInvertedTime implements EvaluationCalculatePercentageInvertedTimeService
{
    public function calculate(EvaluationInvertedTime $invertedTime, Activity $activity): int
    {
        return (int) round(($invertedTime->value() / $activity->time()->value())  * 100);
    }
}