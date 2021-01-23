<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain\Service;

use Academy\Activity\Domain\Activity;
use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Evaluation\Domain\EvaluationCalculateScoreService;

final class EvaluationCalculateScoreScore implements EvaluationCalculateScoreService
{
    /**
     * @param EvaluationAnswer $answer
     * @param Activity $activity
     * @return int
     * @throws \JsonException
     */
    public function calculate(EvaluationAnswer $answer, Activity $activity): int
    {
        $solutionToArray = json_decode(
            $activity->solution()->value(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $mistakes = array_diff_assoc(
            $this->explodeAnswer($answer, $solutionToArray),
            $solutionToArray
        );

        return (int) round(((count($solutionToArray) - count($mistakes)) / count($solutionToArray)) * 100);
    }

    /**
     * @param EvaluationAnswer $answer
     * @param array $solutionToArray
     * @return array
     */
    private function explodeAnswer(EvaluationAnswer $answer, array $solutionToArray): array
    {
        $answer = explode(Activity::SEPARATOR_FOR_SOLUTION, $answer->value());

        for ($unresolvedExercises = 0;
             $unresolvedExercises < count($solutionToArray) - count($answer);
             $unresolvedExercises++) {
            $answer[] = null;
        }

        return $answer;
    }
}