<?php

declare(strict_types=1);

namespace Academy\StudentItineraryProgress\Domain;

use Academy\Activity\Domain\ActivityName;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;

interface StudentItineraryProgressRepo
{
    public function find(ItineraryUuid $itineraryUuid, StudentUuid $studentUuid): ?ActivityName;
}