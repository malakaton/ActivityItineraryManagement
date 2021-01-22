<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Application\GetNextActivity;

use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Application\GetNextActivity\GetNextActivityCommand;
use Academy\Student\Domain\StudentUuid;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Student\Domain\StudentUuidMother;

final class GetNextActivityCommandMother
{
    public static function create(StudentUuid $studentUuid, ItineraryUuid $itineraryUuid): GetNextActivityCommand
    {
        return new GetNextActivityCommand(
            $studentUuid->value(),
            $itineraryUuid->value()
        );
    }

    public static function randomAnswerAndTime(): GetNextActivityCommand
    {
        return self::create(
            new StudentUuid(StudentUuidMother::stub_uuid),
            new ItineraryUuid(ItineraryUuidMother::stub_uuid)
        );
    }
}