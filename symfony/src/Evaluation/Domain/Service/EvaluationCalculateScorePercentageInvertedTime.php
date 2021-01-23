<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain\Service;

use Academy\Activity\Domain\ActivityTime;
use Academy\Evaluation\Domain\EvaluationCalculatePercentageInvertedTimeService;
use Academy\Evaluation\Domain\EvaluationInvertedTime;

final class EvaluationCalculateScorePercentageInvertedTime implements EvaluationCalculatePercentageInvertedTimeService
{
    /**
     * @param EvaluationInvertedTime $invertedTime
     * @param ActivityTime $time
     * @return int
     */
    public function calculate(EvaluationInvertedTime $invertedTime, ActivityTime $time): int
    {
        return (int) round(($invertedTime->value() / $time->value())  * 100);
    }
}