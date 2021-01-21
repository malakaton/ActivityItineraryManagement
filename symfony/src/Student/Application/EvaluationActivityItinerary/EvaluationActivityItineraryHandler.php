<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluationActivityItinerary;

use Academy\Evaluation\Domain\EvaluationFinder;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class EvaluationActivityItineraryHandler implements MessageHandlerInterface
{
    private EvaluationFinder $evaluationFinder;

    public function __construct(EvaluationFinder $evaluationFinder)
    {
        $this->evaluationFinder = $evaluationFinder;
    }

    /**
     * @param EvaluationActivityItineraryCommand $command
     * @return array|null
     * @throws \JsonException
     */
    public function __invoke(EvaluationActivityItineraryCommand $command): ?array
    {
        $studentUuid = new StudentUuid($command->studentUuid());
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());

        return $this->evaluationFinder->__invoke($studentUuid, $itineraryUuid);
    }
}
