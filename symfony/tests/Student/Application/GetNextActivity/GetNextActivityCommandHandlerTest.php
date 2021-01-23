<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Application\GetNextActivity;

use Academy\Itinerary\Domain\ItineraryGuard;
use Academy\Student\Application\GetNextActivity\GetNextActivityHandler;
use Academy\Student\Domain\StudentGuard;
use Academy\Student\Domain\StudentNextActivity;
use Academy\Tests\Activity\Domain\ActivityLevelMother;
use Academy\Tests\Activity\Domain\ActivitySolutionMother;
use Academy\Tests\Activity\Domain\ActivityTimeMother;
use Academy\Tests\Activity\Domain\ActivityIdMother;
use Academy\Tests\Evaluation\Domain\EvaluationCreateDateMother;
use Academy\Tests\Evaluation\Domain\EvaluationPercentageInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationScoreMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Mocks\ActivityItinerary\ActivityItineraryRepositoryMock;
use Academy\Tests\Mocks\Evaluation\EvaluationRepositoryMockUnitTestCase;
use Academy\Tests\Mocks\Itinerary\ItineraryRepositoryMock;
use Academy\Tests\Mocks\Student\StudentRepositoryMock;
use Academy\Tests\Shared\Domain\IntMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Monolog\Logger;

final class GetNextActivityCommandHandlerTest extends EvaluationRepositoryMockUnitTestCase
{
    private GetNextActivityHandler $handler;
    private ActivityItineraryRepositoryMock $activityItineraryRepositoryMock;
    private StudentRepositoryMock $studentRepositoryMock;
    private ItineraryRepositoryMock $itineraryRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activityItineraryRepositoryMock = new ActivityItineraryRepositoryMock();
        $this->studentRepositoryMock = new StudentRepositoryMock();
        $this->itineraryRepositoryMock = new ItineraryRepositoryMock();

        $this->handler = new GetNextActivityHandler(
            new StudentNextActivity(
                $this->activityItineraryRepositoryMock->getMockRepository(),
                new StudentGuard(
                    $this->studentRepositoryMock->getMockRepository(),
                    new Logger(UnitTestCase::LOGGER_TEST_NAME)
                ),
                new ItineraryGuard(
                    $this->itineraryRepositoryMock->getMockRepository(),
                    new Logger(UnitTestCase::LOGGER_TEST_NAME)
                ),
                $this->MockRepository(),
                new Logger(UnitTestCase::LOGGER_TEST_NAME)
            )
        );
    }

    /**
     * @test
     */
    public function it_should_get_next_activity(): void
    {
        $command = GetNextActivityCommandMother::create(
            $this->studentRepositoryMock->getStudentUuid(),
            $this->itineraryRepositoryMock->getItineraryUuid()
        );

        $this->studentRepositoryMock->shouldSearch($this->studentRepositoryMock->getStudentUuid());
        $this->itineraryRepositoryMock->shouldSearch($this->itineraryRepositoryMock->getItineraryUuid());


        $this->shouldGetLastEvaluation(
            [
                'activityId' => ActivityIdMother::create('A1'),
                'itineraryUuid' => ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid),
                'createDate.value' => EvaluationCreateDateMother::random()->value(),
                'studentUuid' =>  StudentUuidMother::create(StudentUuidMother::stub_uuid),
                'level.value' => ActivityLevelMother::getByActivityId(ActivityIdMother::create('A1'))->value(),
                'position.value' =>  IntMother::random(),
                'score.value' => EvaluationScoreMother::create(60)->value(),
                'percentageInvertedTime.value' => EvaluationPercentageInvertedTimeMother::create(80)->value()
            ]
        );

        $this->shouldGetLastStudentActivityEvaluatedByLevel(
            [
                'activityId' => ActivityIdMother::create('A1'),
                'itineraryUuid' => ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid),
                'level.value' => ActivityLevelMother::getByActivityId(ActivityIdMother::create('A1'))->value(),
                'position.value' =>  IntMother::random(),
            ]
        );

        $this->shouldGetStudentActivityEvaluatedByItineraryPosition(
            [
                'activityId' => ActivityIdMother::create('A1'),
                'itineraryUuid' => ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid),
                'level.value' => ActivityLevelMother::getByActivityId(ActivityIdMother::create('A1'))->value(),
                'position.value' =>  IntMother::random(),
            ]
        );

        $this->activityItineraryRepositoryMock->shouldSearchActivityItineraryByCriteria(
            [
                'position.value' => IntMother::random(),
                'activityId' => ActivityIdMother::create('A1'),
                'level.value' => ActivityLevelMother::getByActivityId(ActivityIdMother::create('A1'))->value(),
                'time.value' => ActivityTimeMother::getByActivityId(ActivityIdMother::create('A1'))->value(),
                'solution.value' => ActivitySolutionMother::getByActivityId(ActivityIdMother::create('A1'))->value()
            ]
        );

        $this->dispatch($command, $this->handler);
    }
}