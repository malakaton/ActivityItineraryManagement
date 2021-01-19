<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluateActivity;

use Academy\Activity\Domain\ActivityName;
use Academy\Evaluation\Domain\EvaluationAnswer;
use Academy\Evaluation\Domain\EvaluationCreator;
use Academy\Evaluation\Domain\EvaluationInvertedTime;
use Academy\Itinerary\Domain\ItineraryUuid;
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
     * @return string|null
     * @throws DuplicatedActivity
     */
    public function __invoke(EvaluateActivityCommand $command): ?string
    {
        $studentUuid = new StudentUuid($command->studentUuid());
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());
        $activityName = new ActivityName($command->activityName());
        $answer = new EvaluationAnswer($command->answer());
        $invertedTime = new EvaluationInvertedTime($command->invertedTime());

        return $this->evaluationCreator->__invoke($studentUuid, $itineraryUuid, $activityName, $answer, $invertedTime);
    }
}
