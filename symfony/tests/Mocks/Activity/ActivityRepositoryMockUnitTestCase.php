<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Activity;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
use Academy\Activity\Domain\ActivityUuid;
use Academy\Tests\Activity\Domain\ActivityNameMother;
use Academy\Tests\Activity\Domain\ActivityUuidMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class ActivityRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository ActivityRepository|MockInterface
     */
    private $repository;

    protected ActivityUuid $existingActivityUuid;
    protected ActivityName $existingActivityName;

    protected function setUp(): void
    {
        $this->existingActivityUuid = $this->getExistingActivityUuid();
        $this->existingActivityName = $this->getExistingActivityName();
    }

    protected function getExistingActivityUuid(): ActivityUuid
    {
        return new ActivityUuid(ActivityUuidMother::stub_uuid);
    }

    protected function getExistingActivityName(): ActivityName
    {
        return new ActivityName(ActivityNameMother::stub_name);
    }

    protected function shouldSearchActivity(ActivityName $name, ?Activity $activity): void
    {
        $this->MockRepository()
            ->shouldReceive('searchByName')
            ->with(\Mockery::on(function($argument) use ($name, $activity) {
                $this->assertInstanceOf(ActivityName::class, $argument);
                $this->assertSame($activity->name()->value(), $argument->value());
                $this->assertEquals($argument->value(), $name->value());

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