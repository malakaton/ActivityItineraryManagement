<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\ActivityItinerary;

final class ActivityItineraryRepositoryMock extends ActivityItineraryRepositoryMockUnitTestCase
{
    public function getMockRepository()
    {
        $this->setUp();

        return $this->MockRepository();
    }

    public function shouldSearchActivityItineraryByCriteria(array $activityItinerary): void
    {
        $this->getSearchActivityItineraryByCriteria($activityItinerary);
    }
}