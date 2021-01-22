<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityRepository;
use Academy\Activity\Domain\IActivityGuard;
use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Shared\Infrastructure\Symfony\Exception\SymfonyException;
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
    private Evaluation $evaluation;

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
     * @throws SymfonyException
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
            new EvaluationScore($this->getScore($answer, $this->activityGuard->getActivity())),
            new EvaluationPercentageInvertedTime($this->getScoreInvertedTime(
                $invertedTime,
                $this->activityGuard->getActivity())
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

    /**
     * @param EvaluationAnswer $answer
     * @param Activity $activity
     * @return int
     * @throws SymfonyException
     */
    private function getScore(EvaluationAnswer $answer, Activity $activity): int
    {
        try {
            $solutionToArray = json_decode(
                $activity->solution()->value(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            throw new SymfonyException($e->getMessage(), $e->getTrace());
        }

        $mistakes = array_diff_assoc(
            $this->explodeAnswer($answer, $solutionToArray),
            $solutionToArray
        );

        return (int) round(((count($solutionToArray) - count($mistakes)) / count($solutionToArray)) * 100);
    }

    private function getScoreInvertedTime(EvaluationInvertedTime $invertedTime, Activity $activity): int
    {
        return (int) round(($invertedTime->value() / $activity->time()->value())  * 100);
    }

    private function explodeAnswer(EvaluationAnswer $answer, array $solutionToArray): array
    {
        $answer = explode(Activity::SEPARATOR_FOR_SOLUTION, $answer->value());

        for ($unresolvedExercises = 0;
             $unresolvedExercises < count($solutionToArray) - count($answer);
                $unresolvedExercises++) {
            $answer[] = null;
        }

        return $answer;
    }
}