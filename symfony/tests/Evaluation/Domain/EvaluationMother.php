<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Activity\Domain\ActivityUuid;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Evaluation\Domain\EvaluationCreateDate;
use Academy\Evaluation\Domain\EvaluationInvertedTime;
use Academy\Evaluation\Domain\EvaluationPercentageInvertedTime;
use Academy\Evaluation\Domain\EvaluationScore;
use Academy\Evaluation\Domain\EvaluationUuid;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Application\EvaluateActivity\EvaluateActivityCommand;
use Academy\Student\Domain\StudentUuid;
use Academy\Tests\Activity\Domain\ActivityUuidMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Student\Domain\StudentUuidMother;

final class EvaluationMother
{
    public static function create(
        EvaluationUuid $evaluationUuid,
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
        return new Evaluation(
            $evaluationUuid,
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

    public static function fromRequest(
        EvaluateActivityCommand $request,
        EvaluationScore $score,
        EvaluationPercentageInvertedTime $percentageInvertedTime
    ): Evaluation
    {
        return self::create(
            EvaluationUuidMother::random(),
            ItineraryUuidMother::create($request->itineraryUuid()),
            ActivityUuidMother::create(ActivityUuidMother::stub_uuid),
            StudentUuidMother::create($request->studentUuid()),
            EvaluationCreateDateMother::random(),
            EvaluationAnswerMother::create($request->answer()),
            EvaluationInvertedTimeMother::create($request->invertedTime()),
            $score,
            $percentageInvertedTime
        );
    }

    public static function random(): Evaluation
    {
        return self::create(
            EvaluationUuidMother::random(),
            ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid),
            ActivityUuidMother::create(ActivityUuidMother::stub_uuid),
            StudentUuidMother::create(StudentUuidMother::stub_uuid),
            EvaluationCreateDateMother::random(),
            EvaluationAnswerMother::random(),
            EvaluationInvertedTimeMother::random(),
            EvaluationScoreMother::random(),
            EvaluationPercentageInvertedTimeMother::random()
        );
    }
}