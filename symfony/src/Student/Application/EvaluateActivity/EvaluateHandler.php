<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluateActivity;

use Academy\Activity\Domain\ActivityId;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Evaluation\Domain\EvaluationCreator;
use Academy\Evaluation\Domain\EvaluationInvertedTime;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Shared\Infrastructure\Symfony\Exception\SymfonyException;
use Academy\Student\Domain\StudentUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class EvaluateHandler implements MessageHandlerInterface
{
    private EvaluationCreator $evaluationCreator;

    public function __construct(EvaluationCreator $evaluationCreator)
    {
        $this->evaluationCreator = $evaluationCreator;
    }

    /**
     * @param EvaluateActivityCommand $command
     * @return Evaluation
     * @throws SymfonyException
     */
    public function __invoke(EvaluateActivityCommand $command): Evaluation
    {
        $studentUuid = new StudentUuid($command->studentUuid());
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());
        $activityId = new ActivityId($command->activityId());
        $answer = new EvaluationAnswer($command->answer());
        $invertedTime = new EvaluationInvertedTime($command->invertedTime());

        return $this->evaluationCreator->__invoke($studentUuid, $itineraryUuid, $activityId, $answer, $invertedTime);
    }
}
