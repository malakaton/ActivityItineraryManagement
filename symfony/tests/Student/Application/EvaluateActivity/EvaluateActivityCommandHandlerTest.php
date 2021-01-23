<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Application\EvaluateActivity;

use Academy\Activity\Domain\ActivityGuard;
use Academy\Evaluation\Domain\EvaluationCreator;
use Academy\Evaluation\Domain\Service\EvaluationCalculateScorePercentageInvertedTime;
use Academy\Evaluation\Domain\Service\EvaluationCalculateScoreScore;
use Academy\Itinerary\Domain\ItineraryGuard;
use Academy\Student\Application\EvaluateActivity\EvaluateHandler;
use Academy\Student\Domain\StudentGuard;
use Academy\Tests\Activity\Domain\ActivityMother;
use Academy\Tests\Evaluation\Domain\EvaluationAnswerMother;
use Academy\Tests\Evaluation\Domain\EvaluationInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationMother;
use Academy\Tests\Evaluation\Domain\EvaluationPercentageInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationScoreMother;
use Academy\Tests\Mocks\Activity\ActivityRepositoryMock;
use Academy\Tests\Mocks\Evaluation\EvaluationRepositoryMockUnitTestCase;
use Academy\Tests\Mocks\Itinerary\ItineraryRepositoryMock;
use Academy\Tests\Mocks\Student\StudentRepositoryMock;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Monolog\Logger;

final class EvaluateActivityCommandHandlerTest extends EvaluationRepositoryMockUnitTestCase
{
    private const RIGHT_ANSWER_ACTIVITY_A1 = '1_0_2';
    private const MAX_SCORE = 100;
    private const TIME_TO_ANSWER_ACTIVITY_A1 = 84;
    private const PERCENTAGE_INVERTED_TIME_A1 = 70;

    private EvaluateHandler $handler;
    private ActivityRepositoryMock $activityRepository;
    private StudentRepositoryMock $studentRepositoryMock;
    private ItineraryRepositoryMock $itineraryRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activityRepository = new ActivityRepositoryMock();
        $this->studentRepositoryMock = new StudentRepositoryMock();
        $this->itineraryRepositoryMock = new ItineraryRepositoryMock();

        $this->handler = new EvaluateHandler(
            new EvaluationCreator(
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
            )
        );
    }

    /**
     * @test
     */
    public function it_should_answer_activity_a1_well(): void
    {
        $command = EvaluateActivityCommandMother::create(
            $this->studentRepositoryMock->getStudentUuid(),
            $this->itineraryRepositoryMock->getItineraryUuid(),
            $this->activityRepository->getActivityId(),
            EvaluationAnswerMother::create(self::RIGHT_ANSWER_ACTIVITY_A1),
            EvaluationInvertedTimeMother::create(self::TIME_TO_ANSWER_ACTIVITY_A1)
        );

        $activity = ActivityMother::fromRequest($this->activityRepository->getActivityId());

        $evaluation = EvaluationMother::fromRequest(
            $command,
            EvaluationScoreMother::create(self::MAX_SCORE),
            EvaluationPercentageInvertedTimeMother::create(self::PERCENTAGE_INVERTED_TIME_A1)
        );

        $this->studentRepositoryMock->shouldSearch($this->studentRepositoryMock->getStudentUuid());
        $this->itineraryRepositoryMock->shouldSearch($this->itineraryRepositoryMock->getItineraryUuid());
        $this->activityRepository->shouldSearch($activity->id(), $activity);

        $this->shouldSave($evaluation);

        $this->dispatch($command, $this->handler);
    }
}