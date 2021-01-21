<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluationActivityItinerary;

use Academy\Shared\Domain\Command;

final class EvaluationActivityItineraryCommand implements Command
{
    private string $studentUuid;
    private string $itineraryUuid;

    public function __construct(string $studentUuid, string $itineraryUuid)
    {
        $this->studentUuid = $studentUuid;
        $this->itineraryUuid = $itineraryUuid;
    }

    public function studentUuid(): string
    {
        return $this->studentUuid;
    }

    public function itineraryUuid(): string
    {
        return $this->itineraryUuid;
    }
}
