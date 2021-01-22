<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Student;

use Academy\Student\Domain\StudentRepository;
use Academy\Student\Domain\StudentUuid;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class StudentRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository StudentRepository|MockInterface
     */
    private $repository;

    protected StudentUuid $existingStudentUuid;

    protected function setUp(): void
    {
        $this->existingStudentUuid = $this->getExistingStudentUuid();
    }

    protected function getExistingStudentUuid(): StudentUuid
    {
        return new StudentUuid(StudentUuidMother::stub_uuid);
    }


    protected function shouldSearchStudent(StudentUuid $uuid): void
    {
        $this->MockRepository()
            ->shouldReceive('search')
            ->with(\Mockery::on(function($argument) use ($uuid) {
                $this->assertInstanceOf(StudentUuid::class, $argument);
                $this->assertSame($this->existingStudentUuid->value(), $argument->value());
                $this->assertEquals($argument->value(), $uuid->value());

                return true;
            }))
            ->once()
            ->andReturn(true);
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

    /** @return StudentRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(StudentRepository::class);
    }
}