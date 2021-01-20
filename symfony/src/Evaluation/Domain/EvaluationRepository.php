<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\ActivityLevel;
use Academy\ActivityItinerary\Domain\ActivityItineraryPosition;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;

interface EvaluationRepository
{
    public function save(Evaluation $evaluation): void;
    public function getLastStudentEvaluation(StudentUuid $studentUuid, ItineraryUuid $itineraryUuid): ?array;
    public function getLastStudentActivityEvaluatedByLevel(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityLevel $activityLevel
    ) : ?array;
    public function getStudentActivityEvaluatedByItineraryPosition(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityItineraryPosition $activityItineraryPosition
    ) : ?array;
}