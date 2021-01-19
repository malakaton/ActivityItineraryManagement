<?php

declare(strict_types=1);

namespace Academy\Itinerary\Application\ListingActivity;

use Academy\Shared\Domain\Command;

final class ListingActivityCommand implements Command
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
