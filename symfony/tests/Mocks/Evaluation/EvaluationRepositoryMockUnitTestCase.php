<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Evaluation;

use Academy\Activity\Domain\ActivityUuid;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Evaluation\Domain\EvaluationCreateDate;
use Academy\Evaluation\Domain\EvaluationInvertedTime;
use Academy\Evaluation\Domain\EvaluationPercentageInvertedTime;
use Academy\Evaluation\Domain\EvaluationRepository;
use Academy\Evaluation\Domain\EvaluationScore;
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

    protected function shouldSave(Evaluation $evaluation): void
    {
        $this->MockRepository()
            ->shouldReceive('save')
            ->with(\Mockery::on(function($argument) use ($evaluation) {
                $this->assertInstanceOf(Evaluation::class, $argument);
                $this->assertInstanceOf(EvaluationUuid::class, $argument->uuid());
                $this->assertInstanceOf(ItineraryUuid::class, $argument->itineraryUuid());
                $this->assertInstanceOf(ActivityUuid::class, $argument->activityUuid());
                $this->assertInstanceOf(StudentUuid::class, $argument->studentUuid());
                $this->assertInstanceOf(EvaluationCreateDate::class, $argument->createDate());
                $this->assertInstanceOf(EvaluationAnswer::class, $argument->answer());
                $this->assertInstanceOf(EvaluationInvertedTime::class, $argument->invertedTime());
                $this->assertInstanceOf(EvaluationScore::class, $argument->score());
                $this->assertInstanceOf(EvaluationPercentageInvertedTime::class, $argument->percentageInvertedTime());

                $this->assertEquals($argument->itineraryUuid(), $evaluation->itineraryUuid());
                $this->assertEquals($argument->score(), $evaluation->score());
                $this->assertEquals($argument->answer(), $evaluation->answer());
                $this->assertEquals($argument->invertedTime(), $evaluation->invertedTime());

                return true;
            }))
            ->once()
            ->andReturnNull();
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

    /** @return EvaluationRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(EvaluationRepository::class);
    }
}