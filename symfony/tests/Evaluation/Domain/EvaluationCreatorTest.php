<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Activity\Domain\ActivityGuard;
use Academy\Activity\Domain\ActivityId;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationCreator;
use Academy\Evaluation\Domain\Service\EvaluationCalculateScorePercentageInvertedTime;
use Academy\Evaluation\Domain\Service\EvaluationCalculateScoreScore;
use Academy\Itinerary\Domain\ItineraryGuard;
use Academy\Shared\Infrastructure\Symfony\Exception\SymfonyException;
use Academy\Student\Domain\StudentGuard;
use Academy\Tests\Activity\Domain\ActivityIdMother;
use Academy\Tests\Activity\Domain\ActivityMother;
use Academy\Tests\Mocks\Activity\ActivityRepositoryMock;
use Academy\Tests\Mocks\Evaluation\EvaluationRepositoryMockUnitTestCase;
use Academy\Tests\Mocks\Itinerary\ItineraryRepositoryMock;
use Academy\Tests\Mocks\Student\StudentRepositoryMock;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Monolog\Logger;

final class EvaluationCreatorTest extends EvaluationRepositoryMockUnitTestCase
{
    private ActivityRepositoryMock $activityRepository;
    private StudentRepositoryMock $studentRepositoryMock;
    private ItineraryRepositoryMock $itineraryRepositoryMock;
    private EvaluationCreator $evaluationCreator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activityRepository = new ActivityRepositoryMock();
        $this->studentRepositoryMock = new StudentRepositoryMock();
        $this->itineraryRepositoryMock = new ItineraryRepositoryMock();
        $this->evaluationCreator = new EvaluationCreator(
                new StudentGuard(
                    $this->studentRepositoryMock->getMockRepository(),
                    new Logger(UnitTestCase::LOGGER_TEST_NAME)
                ),
                new ItineraryGuard(
                    $this->itineraryRepositoryMock->getMockRepository(),
                    new Logger(UnitTestCase::LOGGER_TEST_NAME)
                ),
                new ActivityGuard(
                    $this->activityRepository->getMockRepository(),
                    new Logger(UnitTestCase::LOGGER_TEST_NAME)
                ),
                $this->MockRepository(),
                new EvaluationCalculateScoreScore(),
                new EvaluationCalculateScorePercentageInvertedTime(),
                new Logger(UnitTestCase::LOGGER_TEST_NAME)
        );
    }

    /**
     * @test
     * @throws SymfonyException
     */
    public function it_calculate_score_and_percentage_inverted_time_well(): void
    {
        $evaluation = $this->invokeEvaluationCreator('A1', '1_0_2', 50);

        self::assertEquals(100, $evaluation->score()->value());
        self::assertEquals(42, $evaluation->percentageInvertedTime()->value());

        $evaluation = $this->invokeEvaluationCreator('A1', '1_0_1', 10);

        self::assertEquals(67, $evaluation->score()->value());
        self::assertEquals(8, $evaluation->percentageInvertedTime()->value());

        $evaluation= $this->invokeEvaluationCreator('A7', "1_-1_No_34_6", 60);

        self::assertEquals(60, $evaluation->score()->value());
        self::assertEquals(50, $evaluation->percentageInvertedTime()->value());

        $evaluation = $this->invokeEvaluationCreator('A8', "1_8", 30);

        self::assertEquals(50, $evaluation->score()->value());
        self::assertEquals(25, $evaluation->percentageInvertedTime()->value());
    }

    /**
     * @param string $activityId
     * @param string $answer
     * @param int $invertedTime
     * @return Evaluation
     * @throws SymfonyException
     */
    private function invokeEvaluationCreator(string $activityId, string $answer, int $invertedTime): Evaluation
    {
        $this->mockRepositories(ActivityIdMother::create($activityId));

        return $this->evaluationCreator->__invoke(
            $this->studentRepositoryMock->getStudentUuid(),
            $this->itineraryRepositoryMock->getItineraryUuid(),
            ActivityIdMother::create($activityId),
            EvaluationAnswerMother::create($answer),
            EvaluationInvertedTimeMother::create($invertedTime)
        );
    }

    /**
     * @param ActivityId $activityId
     */
    private function mockRepositories(ActivityId $activityId): void
    {
        $activity = ActivityMother::fromRequest($activityId);

        $this->studentRepositoryMock->shouldSearch($this->studentRepositoryMock->getStudentUuid());
        $this->itineraryRepositoryMock->shouldSearch($this->itineraryRepositoryMock->getItineraryUuid());
        $this->activityRepository->shouldSearch($activityId, $activity);

        $this->skipSave();
    }
}