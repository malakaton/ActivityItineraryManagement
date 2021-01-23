<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Activity;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityId;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
use Academy\Tests\Activity\Domain\ActivityIdMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class ActivityRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository ActivityRepository|MockInterface
     */
    private $repository;

    protected ActivityId $existingActivityId;
    protected ActivityName $existingActivityName;

    protected function setUp(): void
    {
        $this->existingActivityId = $this->getExistingActivityId();
    }

    protected function getExistingActivityId(): ActivityId
    {
        return new ActivityId(ActivityIdMother::stub_uuid);
    }

    protected function shouldSearchActivity(ActivityId $id, ?Activity $activity): void
    {
        $this->MockRepository()
            ->shouldReceive('search')
            ->with(\Mockery::on(function($argument) use ($id, $activity) {
                $this->assertInstanceOf(ActivityId::class, $argument);
                $this->assertSame($activity->id()->value(), $argument->value());
                $this->assertEquals($argument->value(), $id->value());

                return true;
            }))
            ->once()
            ->andReturn($activity);
    }

    /** @return ActivityRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(ActivityRepository::class);
    }
}