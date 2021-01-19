<?php

declare(strict_types=1);

namespace Academy\Itinerary\Application\AddActivity;

use Academy\Shared\Domain\Command;

final class AddActivityCommand implements Command
{
    private string $itineraryUuid;
    private string $activityName;

    public function __construct(string $itineraryUuid, string $activityName)
    {
        $this->itineraryUuid = $itineraryUuid;
        $this->activityName = $activityName;
    }

    public function itineraryUuid(): string
    {
        return $this->itineraryUuid;
    }

    public function activityName(): string
    {
        return $this->activityName;
    }
}
