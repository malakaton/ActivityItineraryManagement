<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluateActivity;

use Academy\ActivityItinerary\Domain\ActivityAdder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class EvaluateHandler implements MessageHandlerInterface
{
    private ActivityAdder $activityAdder;

    public function __construct(ActivityAdder $activityAdder)
    {
        $this->activityAdder = $activityAdder;
    }

    /**
     * @param EvaluateActivityCommand $command
     * @return string|null
     * @throws DuplicatedActivity
     */
    public function __invoke(EvaluateActivityCommand $command): ?string
    {
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());
        $activityName = new ActivityName($command->activityName());

        return $this->activityAdder->__invoke($itineraryUuid, $activityName);
    }
}
