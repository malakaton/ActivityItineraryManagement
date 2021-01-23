<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\IActivityGuard;
use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\IStudentGuard;
use Academy\Student\Domain\StudentUuid;
use Psr\Log\LoggerInterface;

final class EvaluationCreator
{
    private IStudentGuard $studentGuard;
    private IItineraryGuard $itineraryGuard;
    private IActivityGuard $activityGuard;
    private EvaluationRepository $evaluationRepository;
    private LoggerInterface $logger;
    private Evaluation $evaluation;
    private EvaluationCalculateScoreService $evaluationCalculateScore;
    private EvaluationCalculatePercentageInvertedTimeService $evaluationCalculatePercentageInvertedTime;

    public function __construct(
        IStudentGuard $studentGuard,
        IItineraryGuard $itineraryGuard,
        IActivityGuard $activityGuard,
        EvaluationRepository $evaluationRepository,
        EvaluationCalculateScoreService $evaluationCalculateScore,
        EvaluationCalculatePercentageInvertedTimeService $evaluationCalculatePercentageInvertedTime,
        LoggerInterface $logger
    ) {
        $this->studentGuard = $studentGuard;
        $this->itineraryGuard = $itineraryGuard;
        $this->activityGuard = $activityGuard;
        $this->evaluationRepository = $evaluationRepository;
        $this->evaluationCalculateScore = $evaluationCalculateScore;
        $this->evaluationCalculatePercentageInvertedTime = $evaluationCalculatePercentageInvertedTime;
        $this->logger = $logger;
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityName $activityName
     * @param EvaluationAnswer $answer
     * @param EvaluationInvertedTime $invertedTime
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityName $activityName,
        EvaluationAnswer $answer,
        EvaluationInvertedTime $invertedTime
    ): string
    {
        $this->studentGuard->guard($studentUuid);
        $this->itineraryGuard->guard($itineraryUuid);
        $this->activityGuard->guard($activityName);

        $this->evaluation = Evaluation::create(
            $itineraryUuid,
            $this->activityGuard->getActivity()->uuid(),
            $studentUuid,
            new EvaluationCreateDate(EvaluationCreateDate::getDateTimeNow()),
            $answer,
            $invertedTime,
            new EvaluationScore(
                $this->evaluationCalculateScore->calculate($answer, $this->activityGuard->getActivity())
            ),
            new EvaluationPercentageInvertedTime(
                $this->evaluationCalculatePercentageInvertedTime->calculate(
                    $invertedTime,
                    $this->activityGuard->getActivity()
                )
            )
        );

        $this->evaluationRepository->save($this->evaluation);

        $message = "Evaluation of activity name: {$this->activityGuard->getActivity()->name()} for student uuid: {$studentUuid->value()} done successfully";

        $this->logger->info($message);

        return $message;
    }

    /**
     * @return Evaluation
     */
    public function getEvaluation(): Evaluation
    {
        return $this->evaluation;
    }
}