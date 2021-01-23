<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Infrastructure\Persistence;

use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationRepository;
use Academy\Evaluation\Infrastructure\Persistence\EvaluationRepositoryMysql;
use Academy\Tests\Evaluation\Domain\EvaluationAnswerMother;
use Academy\Tests\Evaluation\Domain\EvaluationCreateDateMother;
use Academy\Tests\Evaluation\Domain\EvaluationInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationMother;
use Academy\Tests\Evaluation\Domain\EvaluationPercentageInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationScoreMother;
use Academy\Tests\Evaluation\Domain\EvaluationUuidMother;
use Academy\Tests\Activity\Domain\ActivityUuidMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Academy\Tests\Shared\Infrastructure\Doctrine\DoctrineInfrastructureTestCase;

final class EvaluationRepositoryTest extends DoctrineInfrastructureTestCase
{
    private EvaluationRepository $evaluationRepository;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->evaluationRepository = $this->repository(EvaluationRepositoryMysql::class);

        $this->truncateEntity(Evaluation::class);
    }

    /** @test */
    public function it_should_return_an_existing_evaluation(): void
    {
        $evaluation = EvaluationMother::create(
            EvaluationUuidMother::random(),
            ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid),
            ActivityUuidMother::create(ActivityUuidMother::stub_uuid),
            StudentUuidMother::create(StudentUuidMother::stub_uuid),
            EvaluationCreateDateMother::random(),
            EvaluationAnswerMother::random(),
            EvaluationInvertedTimeMother::random(),
            EvaluationScoreMother::random(),
            EvaluationPercentageInvertedTimeMother::random()
        );

        $this->evaluationRepository->save($evaluation);

        $evaluationAfterInsert = $this->evaluationRepository->getLastStudentEvaluation(
            $evaluation->studentUuid(),
            $evaluation->itineraryUuid()
        );

        self::assertEquals(
            $evaluationAfterInsert['activityUuid'],
            $evaluation->activityUuid()
        );

        self::assertEquals(
            $evaluationAfterInsert['itineraryUuid'],
            $evaluation->itineraryUuid()
        );
    }
}