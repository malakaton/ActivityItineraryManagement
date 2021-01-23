<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain;

use Academy\Activity\Domain\ActivityGuard;
use Academy\Activity\Domain\ActivityName;
use Academy\Evaluation\Domain\EvaluationCreator;
use Academy\Itinerary\Domain\ItineraryGuard;
use Academy\Shared\Infrastructure\Symfony\Exception\SymfonyException;
use Academy\Student\Domain\StudentGuard;
use Academy\Tests\Activity\Domain\ActivityMother;
use Academy\Tests\Activity\Domain\ActivityNameMother;
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
                $this->activityRepository->getMockRepository(),
                $this->MockRepository(),
                new Logger(UnitTestCase::LOGGER_TEST_NAME)
        );
    }

    /**
     * @test
     * @throws SymfonyException
     */
    public function it_calculate_score_and_percentage_inverted_time_well(): void
    {
        $this->invokeEvaluationCreator('A1', '1_0_2', 50);

        self::assertEquals(100, $this->evaluationCreator->getEvaluation()->score()->value());
        self::assertEquals(42, $this->evaluationCreator->getEvaluation()->percentageInvertedTime()->value());

        $this->invokeEvaluationCreator('A1', '1_0_1', 10);

        self::assertEquals(67, $this->evaluationCreator->getEvaluation()->score()->value());
        self::assertEquals(8, $this->evaluationCreator->getEvaluation()->percentageInvertedTime()->value());

        $this->invokeEvaluationCreator('A7', "1_-1_'No'_34_6", 60);

        self::assertEquals(60, $this->evaluationCreator->getEvaluation()->score()->value());
        self::assertEquals(50, $this->evaluationCreator->getEvaluation()->percentageInvertedTime()->value());

        $this->invokeEvaluationCreator('A8', "1_8", 30);

        self::assertEquals(50, $this->evaluationCreator->getEvaluation()->score()->value());
        self::assertEquals(25, $this->evaluationCreator->getEvaluation()->percentageInvertedTime()->value());
    }

    /**
     * @param string $activityName
     * @param string $answer
     * @param int $invertedTime
     * @throws SymfonyException
     */
    private function invokeEvaluationCreator(string $activityName, string $answer, int $invertedTime): void
    {
        $this->mockRepositories(ActivityNameMother::create($activityName));

        $this->evaluationCreator->__invoke(
            $this->studentRepositoryMock->getStudentUuid(),
            $this->itineraryRepositoryMock->getItineraryUuid(),
            ActivityNameMother::create($activityName),
            EvaluationAnswerMother::create($answer),
            EvaluationInvertedTimeMother::create($invertedTime)
        );
    }

    /**
     * @param ActivityName $activityName
     */
    private function mockRepositories(ActivityName $activityName): void
    {
        $activity = ActivityMother::fromRequest($activityName);

        $this->studentRepositoryMock->shouldSearch($this->studentRepositoryMock->getStudentUuid());
        $this->itineraryRepositoryMock->shouldSearch($this->itineraryRepositoryMock->getItineraryUuid());
        $this->activityRepository->shouldSearch($activity->name(), $activity);

        $this->skipSave();
    }
}