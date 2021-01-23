<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Domain;

use Academy\ActivityItinerary\Domain\ActivityItinerary;
use Academy\ActivityItinerary\Infrastructure\Persistence\ActivityItineraryRepositoryMysql;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationRepository;
use Academy\Evaluation\Infrastructure\Persistence\EvaluationRepositoryMysql;
use Academy\Itinerary\Domain\ItineraryGuard;
use Academy\Student\Domain\StudentGuard;
use Academy\Student\Domain\StudentNextActivity;
use Academy\Tests\Activity\Domain\ActivityNameMother;
use Academy\Tests\Activity\Domain\ActivityIdMother;
use Academy\Tests\Evaluation\Domain\EvaluationAnswerMother;
use Academy\Tests\Evaluation\Domain\EvaluationCreateDateMother;
use Academy\Tests\Evaluation\Domain\EvaluationInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationMother;
use Academy\Tests\Evaluation\Domain\EvaluationPercentageInvertedTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationScoreMother;
use Academy\Tests\Evaluation\Domain\EvaluationUuidMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Mocks\Itinerary\ItineraryRepositoryMock;
use Academy\Tests\Mocks\Student\StudentRepositoryMock;
use Academy\Tests\Shared\Infrastructure\Doctrine\DoctrineInfrastructureTestCase;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Monolog\Logger;

final class StudentNextActivityTest extends DoctrineInfrastructureTestCase
{
    private const ADD_MINUTES_EVALUATION_CREATE_DATE = '+1 minutes';

    private StudentRepositoryMock $studentRepositoryMock;
    private ItineraryRepositoryMock $itineraryRepositoryMock;
    private StudentNextActivity $studentNextActivity;
    private EvaluationRepository $evaluationRepository;
    private array $sequenceNextActivities = [
        [
            'activity_name' => 'A1',
            'answer' => '1_0_2',
            'inverted_time' => 90,
            'score' => 100,
            'percentage_inverted_time' => 75,
            'next_activity_name' => 'A2'
        ],
        [
            'activity_name' => 'A2',
            'answer' => '-2_40_56',
            'inverted_time' => 15,
            'score' => 100,
            'percentage_inverted_time' => 25,
            'next_activity_name' => 'A5'
        ],
        [
            'activity_name' => 'A5',
            'answer' => '0_2_1',
            'inverted_time' => 180,
            'score' => 0,
            'percentage_inverted_time' => 150,
            'next_activity_name' => 'A3'
        ],
        [
            'activity_name' => 'A3',
            'answer' => '1_1',
            'inverted_time' => 100,
            'score' => 50,
            'percentage_inverted_time' => 83,
            'next_activity_name' => 'A3'
        ],
        [
            'activity_name' => 'A3',
            'answer' => '1_0',
            'inverted_time' => 80,
            'score' => 100,
            'percentage_inverted_time' => 67,
            'next_activity_name' => 'A4'
        ],
        [
            'activity_name' => 'A4',
            'answer' => '1_0_2_-4_9',
            'inverted_time' => 100,
            'score' => 80,
            'percentage_inverted_time' => 56,
            'next_activity_name' => 'A5'
        ],
        [
            'activity_name' => 'A5',
            'answer' => '1_0_2',
            'inverted_time' => 20,
            'score' => 100,
            'percentage_inverted_time' => 20,
            'next_activity_name' => 'A7'
        ],
        [
            'activity_name' => 'A7',
            'answer' => "7_-9_No_24_-9",
            'inverted_time' => 120,
            'score' => 0,
            'percentage_inverted_time' => 100,
            'next_activity_name' => 'A6'
        ],
        [
            'activity_name' => 'A6',
            'answer' => "1_0_2",
            'inverted_time' => 20,
            'score' => 100,
            'percentage_inverted_time' => 17,
            'next_activity_name' => 'A7'
        ],
        [
            'activity_name' => 'A7',
            'answer' => "1_0_2",
            'inverted_time' => 20,
            'score' => 100,
            'percentage_inverted_time' => 17,
            'next_activity_name' => 'A9'
        ],
        [
            'activity_name' => 'A9',
            'answer' => "1_0_2",
            'inverted_time' => 20,
            'score' => 100,
            'percentage_inverted_time' => 17,
            'next_activity_name' => 'A10'
        ],
        [
            'activity_name' => 'A10',
            'answer' => "1_0_2",
            'inverted_time' => 70,
            'score' => 100,
            'percentage_inverted_time' => 59,
            'next_activity_name' => 'A11'
        ],
        [
            'activity_name' => 'A12',
            'answer' => "1_0_2",
            'inverted_time' => 70,
            'score' => 100,
            'percentage_inverted_time' => 59,
            'next_activity_name' => 'A13'
        ],
        [
            'activity_name' => 'A13',
            'answer' => "3_4_1",
            'inverted_time' => 120,
            'score' => 0,
            'percentage_inverted_time' => 100,
            'next_activity_name' => 'A13'
        ],
        [
            'activity_name' => 'A13',
            'answer' => "1_0_2",
            'inverted_time' => 70,
            'score' => 100,
            'percentage_inverted_time' => 59,
            'next_activity_name' => ''
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->evaluationRepository = new EvaluationRepositoryMysql($this->entityManager);
        $this->studentRepositoryMock = new StudentRepositoryMock();
        $this->itineraryRepositoryMock = new ItineraryRepositoryMock();
        $this->studentNextActivity = new StudentNextActivity(
            new ActivityItineraryRepositoryMysql($this->entityManager),
            new StudentGuard(
                $this->studentRepositoryMock->getMockRepository(),
                new Logger(UnitTestCase::LOGGER_TEST_NAME)
            ),
            new ItineraryGuard(
                $this->itineraryRepositoryMock->getMockRepository(),
                new Logger(UnitTestCase::LOGGER_TEST_NAME)
            ),
            $this->evaluationRepository,
            new Logger(UnitTestCase::LOGGER_TEST_NAME)
        );

        $this->truncateEntity(Evaluation::class);

        $qb = $this->entityManager->createQueryBuilder();

        $qb->delete(ActivityItinerary::class, 'ai')
            ->where('ai.activityId = (:id)')
            ->setParameter('id', ActivityIdMother::FAKE_ACTIVITY_UUID_STUB)
            ->getQuery()
            ->execute();
    }

    /**
     * @test
     */
    public function should_sequence_next_activities_works(): void
    {
        $this->mockRepositories();
        $dateTime = new \DateTime('now');

        foreach ($this->sequenceNextActivities as $sequenceNextActivity) {
            $dateTime->modify(self::ADD_MINUTES_EVALUATION_CREATE_DATE);

             $this->evaluationRepository->save(
                EvaluationMother::create(
                    EvaluationUuidMother::random(),
                    ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid),
                    ActivityIdMother::getByActivityName(
                        ActivityNameMother::create($sequenceNextActivity['activity_name'])
                    ),
                    StudentUuidMother::create(StudentUuidMother::stub_uuid),
                    //Needed to avoid add some evaluation with the same datetime and this is not true
                    // (student cannot do two activities at the same time)
                    EvaluationCreateDateMother::create($dateTime),
                    EvaluationAnswerMother::create($sequenceNextActivity['answer']),
                    EvaluationInvertedTimeMother::create($sequenceNextActivity['inverted_time']),
                    EvaluationScoreMother::create($sequenceNextActivity['score']),
                    EvaluationPercentageInvertedTimeMother::create($sequenceNextActivity['percentage_inverted_time'])
                )
            );

            self::assertEquals($this->invokeStudentNextActivity(), $sequenceNextActivity['next_activity_name']);
        }
    }

    /**
     * @return string
     */
    private function invokeStudentNextActivity(): string
    {
        return $this->studentNextActivity->__invoke(
            StudentUuidMother::create(StudentUuidMother::stub_uuid),
            ItineraryUuidMother::create(ItineraryUuidMother::stub_uuid)
        )['activity_name'] ?? '';
    }

    private function mockRepositories(): void
    {
        $this->studentRepositoryMock->shouldSearch($this->studentRepositoryMock->getStudentUuid());
        $this->itineraryRepositoryMock->shouldSearch($this->itineraryRepositoryMock->getItineraryUuid());
    }

}