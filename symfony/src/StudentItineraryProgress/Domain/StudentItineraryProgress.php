<?php

declare(strict_types=1);

namespace Academy\StudentItineraryProgress\Domain;

use Academy\Activity\Domain\ActivityUuid;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;

final class StudentItineraryProgress
{
    private StudentItineraryProgressUuid $uuid;
    private ItineraryUuid $itineraryUuid;
    private StudentUuid $studentUuid;
    private ?ActivityUuid $previousActivityUuid;
    private ?ActivityUuid $nextActivityUuid;
    private ?StudentItineraryProgressHasIncreasedLevel $hasIncreasedLevel;

    public function __construct(
        StudentItineraryProgressUuid $uuid,
        ItineraryUuid $itineraryUuid,
        StudentUuid $studentUid,
        ?ActivityUuid $previousActivityUuid,
        ?ActivityUuid $nextActivityUuid,
        ?StudentItineraryProgressHasIncreasedLevel $hasIncreasedLevel
    )
    {
        $this->uuid = $uuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->studentUuid = $studentUid;
        $this->previousActivityUuid = $previousActivityUuid;
        $this->nextActivityUuid = $nextActivityUuid;
        $this->hasIncreasedLevel = $hasIncreasedLevel;
    }

    public static function update(
        StudentItineraryProgressUuid $uuid,
        ItineraryUuid $itineraryUuid,
        StudentUuid $studentUuid,
        ?ActivityUuid $previousActivityUuid,
        ?ActivityUuid $nextActivityUuid,
        ?StudentItineraryProgressHasIncreasedLevel $hasIncreasedLevel
    ): StudentItineraryProgress
    {
        return new self($uuid, $itineraryUuid, $studentUuid, $previousActivityUuid, $nextActivityUuid, $hasIncreasedLevel);
    }

    public function uuid(): StudentItineraryProgressUuid
    {
        return $this->uuid;
    }

    public function itineraryUuid(): ItineraryUuid
    {
        return $this->itineraryUuid;
    }

    public function studentUuid(): StudentUuid
    {
        return $this->studentUuid;
    }

    public function previousActivityUuid(): ?ActivityUuid
    {
        return $this->previousActivityUuid;
    }

    public function nextActivityUuid(): ?ActivityUuid
    {
        return $this->nextActivityUuid;
    }

    public function hasIncreasedLevel(): ?StudentItineraryProgressHasIncreasedLevel
    {
        return $this->hasIncreasedLevel;
    }
}