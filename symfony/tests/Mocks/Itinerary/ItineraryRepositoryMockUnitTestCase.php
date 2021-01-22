<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Itinerary;

use Academy\Itinerary\Domain\ItineraryRepository;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Tests\Itinerary\Domain\ItineraryMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class ItineraryRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository ItineraryRepository|MockInterface
     */
    private $repository;

    protected ItineraryUuid $existingItineraryUuid;

    protected function setUp(): void
    {
        $this->existingItineraryUuid = $this->getExistingItineraryUuid();
    }

    protected function getExistingItineraryUuid(): ItineraryUuid
    {
        return new ItineraryUuid(ItineraryUuidMother::stub_uuid);
    }

    protected function shouldSearchItinerary(ItineraryUuid $uuid): void
    {
        $this->MockRepository()
            ->shouldReceive('search')
            ->with(\Mockery::on(function($argument) use ($uuid) {
                $this->assertInstanceOf(ItineraryUuid::class, $argument);
                $this->assertSame($this->existingItineraryUuid->value(), $argument->value());
                $this->assertEquals($argument->value(), $uuid->value());

                return true;
            }))
            ->once()
            ->andReturn(ItineraryMother::fromRequest($uuid));
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

    /** @return ItineraryRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(ItineraryRepository::class);
    }
}