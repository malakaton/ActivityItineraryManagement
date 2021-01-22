<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\ActivityItinerary;

use Academy\ActivityItinerary\Domain\ActivityItineraryRepository;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class ActivityItineraryRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository ActivityItineraryRepository|MockInterface
     */
    private $repository;

    protected function getSearchActivityItineraryByCriteria(array $activityItinerary): void
    {
        $this->MockRepository()
            ->shouldReceive('getActivityItineraryByCriteria')
            ->withAnyArgs()
            ->once()
            ->andReturn($activityItinerary);
    }

    /** @return ActivityItineraryRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(ActivityItineraryRepository::class);
    }
}