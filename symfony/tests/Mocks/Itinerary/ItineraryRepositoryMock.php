<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Itinerary;

use Academy\Itinerary\Domain\ItineraryUuid;

final class ItineraryRepositoryMock extends ItineraryRepositoryMockUnitTestCase
{
    public function getMockRepository()
    {
        $this->setUp();

        return $this->MockRepository();
    }

    public function getItineraryUuid(): ItineraryUuid
    {
        return $this->existingItineraryUuid;
    }

    public function shouldSearch(ItineraryUuid $uuid): void
    {
        $this->shouldSearchItinerary($uuid);
    }
}