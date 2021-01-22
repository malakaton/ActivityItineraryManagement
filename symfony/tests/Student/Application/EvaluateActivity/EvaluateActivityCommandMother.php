<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Application\EvaluateActivity;

use Academy\Activity\Domain\ActivityName;
use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Evaluation\Domain\EvaluationInvertedTime;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Application\EvaluateActivity\EvaluateActivityCommand;
use Academy\Student\Domain\StudentUuid;
use Academy\Tests\Activity\Domain\ActivityNameMother;
use Academy\Tests\Evaluation\Domain\EvaluationAnswerMother;
use Academy\Tests\Evaluation\Domain\EvaluationInvertedTimeMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Student\Domain\StudentUuidMother;

final class EvaluateActivityCommandMother
{
    public static function create(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityName $activityName,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime
    ): EvaluateActivityCommand
    {
        return new EvaluateActivityCommand(
            $studentUuid->value(),
            $itineraryUuid->value(),
            $activityName->value(),
            $answer->value(),
            $invertedTime->value()
        );
    }

    public static function randomAnswerAndTime(): EvaluateActivityCommand
    {
        return self::create(
            new StudentUuid(StudentUuidMother::stub_uuid),
            new ItineraryUuid(ItineraryUuidMother::stub_uuid),
            new ActivityName(ActivityNameMother::stub_name),
            EvaluationAnswerMother::random(),
            EvaluationInvertedTimeMother::random()
        );
    }
}