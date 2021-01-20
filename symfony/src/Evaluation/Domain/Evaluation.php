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
    private EvaluationCreateDate $createDate;
    private EvaluationAnswer $answer;
    private EvaluationInvertedTime $invertedTime;
    private EvaluationScore $score;
    private EvaluationPercentageInvertedTime $percentageInvertedTime;

    public function __construct(
        EvaluationUuid $uuid,
        ItineraryUuid $itineraryUuid,
        ActivityUuid $activityUuid,
        StudentUuid $studentUuid,
        EvaluationCreateDate $createDate,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime,
        EvaluationScore $score,
        EvaluationPercentageInvertedTime $percentageInvertedTime
    )
    {
        $this->uuid = $uuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->activityUuid = $activityUuid;
        $this->studentUuid = $studentUuid;
        $this->createDate = $createDate;
        $this->answer = $answer;
        $this->invertedTime = $invertedTime;
        $this->score = $score;
        $this->percentageInvertedTime = $percentageInvertedTime;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityUuid $activityUuid
     * @param StudentUuid $studentUuid
     * @param EvaluationCreateDate $createDate
     * @param EvaluationAnswer $answer
     * @param EvaluationInvertedTime $invertedTime
     * @param EvaluationScore $score
     * @param EvaluationPercentageInvertedTime $percentageInvertedTime
     * @return Evaluation
     */
    public static function create(
        ItineraryUuid $itineraryUuid,
        ActivityUuid $activityUuid,
        StudentUuid $studentUuid,
        EvaluationCreateDate $createDate,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime,
        EvaluationScore $score,
        EvaluationPercentageInvertedTime $percentageInvertedTime
    ): Evaluation
    {
        return new self(
            EvaluationUuid::random(),
            $itineraryUuid,
            $activityUuid,
            $studentUuid,
            $createDate,
            $answer,
            $invertedTime,
            $score,
            $percentageInvertedTime
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

    public function createDate(): EvaluationCreateDate
    {
        return $this->createDate;
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

    public function percentageInvertedTime(): EvaluationPercentageInvertedTime
    {
        return $this->percentageInvertedTime;
    }
}