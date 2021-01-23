<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain\Service;

use Academy\Evaluation\Domain\EvaluationCalculateScoreService;
use Academy\Evaluation\Domain\Service\EvaluationCalculateScoreScore;
use Academy\Tests\Activity\Domain\ActivityIdMother;
use Academy\Tests\Activity\Domain\ActivitySolutionMother;
use Academy\Tests\Evaluation\Domain\EvaluationAnswerMother;
use PHPUnit\Framework\TestCase;

final class EvaluationCalculateScoreTest extends TestCase
{
    private EvaluationCalculateScoreService $evaluationCalculateScore;

    protected function setUp(): void
    {
        parent::setUp();

        $this->evaluationCalculateScore = new EvaluationCalculateScoreScore();
    }


    /**
     * @test
     * @throws \JsonException
     */
    public function it_calculate_score_works(): void
    {
        self::assertEquals(
            100,
            $this->evaluationCalculateScore->calculate(
                EvaluationAnswerMother::create(
                    "1_0_2"
                ),
                ActivitySolutionMother::getByActivityId(
                    ActivityIdMother::create('A1')
                )
            )
        );

        self::assertEquals(
            33,
            $this->evaluationCalculateScore->calculate(
                EvaluationAnswerMother::create(
                    "1_2_1"
                ),
                ActivitySolutionMother::getByActivityId(
                    ActivityIdMother::create('A1')
                )
            )
        );

        self::assertEquals(
            67,
            $this->evaluationCalculateScore->calculate(
                EvaluationAnswerMother::create(
                    "2_40_56"
                ),
                ActivitySolutionMother::getByActivityId(
                    ActivityIdMother::create('A2')
                )
            )
        );

        self::assertEquals(
            100,
            $this->evaluationCalculateScore->calculate(
                EvaluationAnswerMother::create(
                    '1_-1_Si_34_-6'
                ),
                ActivitySolutionMother::getByActivityId(
                    ActivityIdMother::create('A7')
                )
            )
        );

        self::assertEquals(
            80,
            $this->evaluationCalculateScore->calculate(
                EvaluationAnswerMother::create(
                    '1_-1_No_34_-6'
                ),
                ActivitySolutionMother::getByActivityId(
                    ActivityIdMother::create('A7')
                )
            )
        );

        self::assertEquals(
            0,
            $this->evaluationCalculateScore->calculate(
                EvaluationAnswerMother::create(
                    ''
                ),
                ActivitySolutionMother::getByActivityId(
                    ActivityIdMother::create('A8')
                )
            )
        );
    }

}