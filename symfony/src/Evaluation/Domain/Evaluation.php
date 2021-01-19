<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\ActivityUuid;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;

final class Evaluation
{
    private EvaluationUuid $uuid;
    private ItineraryUuid $itineraryUuid;
    private ActivityUuid $activityUuid;
    private StudentUuid $studentUuid;
    private EvaluationAnswer $answer;
    private EvaluationInvertedTime $invertedTime;
    private EvaluationScore $score;
    private EvaluationScoreInvertedTime $scoreInvertedTime;

    public function __construct(
        EvaluationUuid $uuid,
        ItineraryUuid $itineraryUuid,
        ActivityUuid $activityUuid,
        StudentUuid $studentUuid,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime,
        EvaluationScore $score,
        EvaluationScoreInvertedTime $scoreInvertedTime
    )
    {
        $this->uuid = $uuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->activityUuid = $activityUuid;
        $this->studentUuid = $studentUuid;
        $this->answer = $answer;
        $this->invertedTime = $invertedTime;
        $this->score = $score;
        $this->scoreInvertedTime = $scoreInvertedTime;
    }

    public static function create(
        EvaluationUuid $uuid,
        ItineraryUuid $itineraryUuid,
        ActivityUuid $activityUuid,
        StudentUuid $studentUuid,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime,
        EvaluationScore $score,
        EvaluationScoreInvertedTime $scoreInvertedTime
    ): Evaluation
    {
        return new self(
            $uuid,
            $itineraryUuid,
            $activityUuid,
            $studentUuid,
            $answer,
            $invertedTime,
            $score,
            $scoreInvertedTime
        );
    }

    public function uuid(): EvaluationUuid
    {
        return $this->uuid;
    }

    public function itineraryUuid(): ItineraryUuid
    {
        return $this->itineraryUuid;
    }

    public function activityUuid(): ActivityUuid
    {
        return $this->activityUuid;
    }

    public function studentUuid(): StudentUuid
    {
        return $this->studentUuid;
    }

    public function answer(): EvaluationAnswer
    {
        return $this->answer;
    }

    public function invertedTime(): EvaluationInvertedTime
    {
        return $this->invertedTime;
    }

    public function score(): EvaluationScore
    {
        return $this->score;
    }

    public function scoreInvertedTime(): EvaluationScoreInvertedTime
    {
        return $this->scoreInvertedTime;
    }
}