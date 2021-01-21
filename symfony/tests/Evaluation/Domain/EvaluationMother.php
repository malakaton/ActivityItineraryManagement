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
use Academy\Student\Domain\StudentUuid;

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

//    public static function fromRequest(EvaluationComm $request): Book
//    {
//        return self::create(
//            BookUuidMother::random(),
//            AuthorUuidMother::create($request->authorUuid()),
//            BookTitleMother::create($request->title()),
//            BookDescriptionMother::create($request->description()),
//            BookContentMother::create($request->content())
//        );
//    }
//
//    public static function random(string $uuid): Book
//    {
//        return self::create(
//            BookUuidMother::create($uuid),
//            AuthorUuidMother::random(),
//            BookTitleMother::random(),
//            BookDescriptionMother::random(),
//            BookContentMother::random()
//        );
//    }
}