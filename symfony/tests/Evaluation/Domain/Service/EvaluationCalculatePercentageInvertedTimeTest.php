<?php

declare(strict_types=1);

namespace Academy\Tests\Evaluation\Domain\Service;

use Academy\Evaluation\Domain\EvaluationCalculatePercentageInvertedTimeService;
use Academy\Evaluation\Domain\Service\EvaluationCalculateScorePercentageInvertedTime;
use Academy\Tests\Activity\Domain\ActivityIdMother;
use Academy\Tests\Activity\Domain\ActivityTimeMother;
use Academy\Tests\Evaluation\Domain\EvaluationInvertedTimeMother;
use PHPUnit\Framework\TestCase;

final class EvaluationCalculatePercentageInvertedTimeTest extends TestCase
{
    private EvaluationCalculatePercentageInvertedTimeService $evaluationCalculatePercentageInvertedTime;

    protected function setUp(): void
    {
        parent::setUp();

        $this->evaluationCalculatePercentageInvertedTime = new EvaluationCalculateScorePercentageInvertedTime();
    }

    /**
     * @test
     * @throws \JsonException
     */
    public function it_calculate_percentage_inverted_works(): void
    {
        self::assertEquals(
            100,
            $this->evaluationCalculatePercentageInvertedTime->calculate(
                EvaluationInvertedTimeMother::create(
                    120
                ),
                ActivityTimeMother::getByActivityId(
                    ActivityIdMother::create('A1')
                )
            )
        );

        self::assertEquals(
            25,
            $this->evaluationCalculatePercentageInvertedTime->calculate(
                EvaluationInvertedTimeMother::create(
                    30
                ),
                ActivityTimeMother::getByActivityId(
                    ActivityIdMother::create('A1')
                )
            )
        );

        self::assertEquals(
            50,
            $this->evaluationCalculatePercentageInvertedTime->calculate(
                EvaluationInvertedTimeMother::create(
                    30
                ),
                ActivityTimeMother::getByActivityId(
                    ActivityIdMother::create('A2')
                )
            )
        );

        self::assertEquals(
            33,
            $this->evaluationCalculatePercentageInvertedTime->calculate(
                EvaluationInvertedTimeMother::create(
                    40
                ),
                ActivityTimeMother::getByActivityId(
                    ActivityIdMother::create('A7')
                )
            )
        );

        self::assertEquals(
            17,
            $this->evaluationCalculatePercentageInvertedTime->calculate(
                EvaluationInvertedTimeMother::create(
                    20
                ),
                ActivityTimeMother::getByActivityId(
                    ActivityIdMother::create('A7')
                )
            )
        );

        self::assertEquals(
            0,
            $this->evaluationCalculatePercentageInvertedTime->calculate(
                EvaluationInvertedTimeMother::create(
                    0
                ),
                ActivityTimeMother::getByActivityId(
                    ActivityIdMother::create('A8')
                )
            )
        );
    }
}