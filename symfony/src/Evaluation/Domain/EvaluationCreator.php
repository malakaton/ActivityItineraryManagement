<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
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
    private ActivityRepository $activityRepository;
    private EvaluationRepository $evaluationRepository;
    private LoggerInterface $logger;

    public function __construct(
        IStudentGuard $studentGuard,
        IItineraryGuard $itineraryGuard,
        IActivityGuard $activityGuard,
        ActivityRepository $activityRepository,
        EvaluationRepository $evaluationRepository,
        LoggerInterface $logger
    ) {
        $this->studentGuard = $studentGuard;
        $this->itineraryGuard = $itineraryGuard;
        $this->activityGuard = $activityGuard;
        $this->activityRepository = $activityRepository;
        $this->evaluationRepository = $evaluationRepository;
        $this->logger = $logger;
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityName $activityName
     * @param EvaluationAnswer $answer
     * @param EvaluationInvertedTime $invertedTime
     * @return string
     * @throws \JsonException
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

        $activity = $this->activityRepository->searchByName($this->activityGuard->getActivity()->name());

        $this->evaluationRepository->getLastStudentEvaluation($studentUuid, $itineraryUuid);

        $evaluation = Evaluation::create(
            $itineraryUuid,
            $this->activityGuard->getActivity()->uuid(),
            $studentUuid,
            $answer,
            $invertedTime,
            new EvaluationScore($this->getScore($answer, $activity)),
            new EvaluationPercentageInvertedTime($this->getScoreInvertedTime($invertedTime, $activity))
        );

        $this->evaluationRepository->save($evaluation);

        $message = "Evaluation of activity name: {$this->activityGuard->getActivity()->name()} for student uuid: {$studentUuid->value()} done successfully";

        $this->logger->info($message);

        return $message;
    }

    /**
     * @param EvaluationAnswer $answer
     * @param Activity $activity
     * @return int
     * @throws \JsonException
     */
    private function getScore(EvaluationAnswer $answer, Activity $activity): int
    {
        $solutionToArray = json_decode($activity->solution()->value(), true, 512, JSON_THROW_ON_ERROR);

        $mistakes = array_diff_assoc(
            $this->explodeAnswer($answer),
            $solutionToArray
        );

        return (int) round(((count($solutionToArray) - count($mistakes)) / count($solutionToArray)) * 100);
    }

    private function getScoreInvertedTime(EvaluationInvertedTime $invertedTime, Activity $activity): int
    {
        return (int) round(($invertedTime->value() / $activity->time()->value())  * 100);
    }

    private function explodeAnswer(EvaluationAnswer $answer): array
    {
        return explode(Activity::SEPARATOR_FOR_SOLUTION, $answer->value());
    }
}