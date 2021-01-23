<?php

declare(strict_types=1);

namespace Academy\Itinerary\Application\AddActivity;

use Academy\Activity\Domain\ActivityId;
use Academy\ActivityItinerary\Domain\ActivityAdder;
use Academy\ActivityItinerary\Domain\Exception\DuplicatedActivity;
use Academy\Itinerary\Domain\ItineraryUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddActivityHandler implements MessageHandlerInterface
{
    private ActivityAdder $activityAdder;

    public function __construct(ActivityAdder $activityAdder)
    {
        $this->activityAdder = $activityAdder;
    }

    /**
     * @param AddActivityCommand $command
     * @return string|null
     * @throws DuplicatedActivity
     */
    public function __invoke(AddActivityCommand $command): ?string
    {
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());
        $activityId = new ActivityId($command->activityId());

        return $this->activityAdder->__invoke($itineraryUuid, $activityId);
    }
}
