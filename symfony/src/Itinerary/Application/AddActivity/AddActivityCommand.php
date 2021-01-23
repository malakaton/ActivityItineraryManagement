<?php

declare(strict_types=1);

namespace Academy\Itinerary\Application\AddActivity;

use Academy\Shared\Domain\Command;

final class AddActivityCommand implements Command
{
    private string $itineraryUuid;
    private string $activityId;

    public function __construct(string $itineraryUuid, string $activityId)
    {
        $this->itineraryUuid = $itineraryUuid;
        $this->activityId = $activityId;
    }

    public function itineraryUuid(): string
    {
        return $this->itineraryUuid;
    }

    public function activityId(): string
    {
        return $this->activityId;
    }
}
