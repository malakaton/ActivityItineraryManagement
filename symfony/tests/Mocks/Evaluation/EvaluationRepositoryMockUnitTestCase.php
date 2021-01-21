<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Evaluation;

use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationRepository;
use Academy\Evaluation\Domain\EvaluationUuid;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;
use Academy\Tests\Shared\Domain\UuidMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class EvaluationRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository EvaluationRepository|MockInterface
     */
    private $repository;

    protected EvaluationUuid $randomEvaluationUuid;

    protected function setUp(): void
    {
        $this->randomEvaluationUuid = $this->getRandomEvaluationUuid();
    }

    protected function getRandomEvaluationUuid(): EvaluationUuid
    {
        return new EvaluationUuid(UuidMother::random());
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

    /** @return EvaluationRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(EvaluationRepository::class);
    }
}