<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Activity;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
use Academy\Activity\Domain\ActivityUuid;
use Academy\Student\Domain\StudentUuid;
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

//    protected function shouldSave(Book $book): void
//    {
//        $this->MockRepository()
//            ->shouldReceive('save')
//            ->with(\Mockery::on(function($argument) use ($book) {
//                $this->assertInstanceOf(Book::class, $argument);
//                $this->assertInstanceOf(BookUuid::class, $argument->uuid());
//                $this->assertInstanceOf(AuthorUuid::class, $argument->authorUuid());
//                $this->assertInstanceOf(BookTitle::class, $argument->title());
//                $this->assertInstanceOf(BookDescription::class, $argument->description());
//                $this->assertInstanceOf(BookContent::class, $argument->content());
//
//                $this->assertEquals($argument->authorUuid(), $book->authorUuid());
//                $this->assertEquals($argument->title(), $book->title());
//                $this->assertEquals($argument->description(), $book->description());
//                $this->assertEquals($argument->content(), $book->content());
//
//                return true;
//            }))
//            ->once()
//            ->andReturnNull();
//    }

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

    protected function shouldGetLastEvaluation(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        Evaluation $evaluation
    ): void {
        $this->MockRepository()
            ->shouldReceive('getEvaluationByStudentItineraryUuid')
            ->with(\Mockery::on(function($argument) use ($studentUuid, $itineraryUuid) {
                $this->assertInstanceOf(StudentUuid::class, $argument);
                $this->assertSame($this->randomEvaluationUuid->value(), $argument->value());
                $this->assertEquals($argument->value(), $studentUuid->value());

                return true;
            }))
            ->once()
            ->andReturn($evaluation);
    }

    /** @return ActivityRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(ActivityRepository::class);
    }
}