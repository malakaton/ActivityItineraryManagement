<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Application\ShowListActivity;

use Academy\Shared\Domain\Command;

final class ShowListActivityCommand implements Command
{
    private string $itineraryUuid;

    public function __construct(string $itineraryUuid)
    {
        $this->itineraryUuid = $itineraryUuid;
    }

    public function itineraryUuid(): string
    {
        return $this->itineraryUuid;
    }
}
