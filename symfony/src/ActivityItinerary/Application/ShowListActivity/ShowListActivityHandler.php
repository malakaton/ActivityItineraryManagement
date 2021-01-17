<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Application\ShowListActivity;

use Academy\ActivityItinerary\Domain\ActivityFinder;
use Academy\Itinerary\Domain\ItineraryUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ShowListActivityHandler implements MessageHandlerInterface
{
    private ActivityFinder $activityFinder;

    public function __construct(ActivityFinder $activityFinder)
    {
        $this->activityFinder = $activityFinder;
    }

    /**
     * @param ShowListActivityCommand $command
     * @return array|null
     */
    public function __invoke(ShowListActivityCommand $command): ?array
    {
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());

        return $this->activityFinder->__invoke($itineraryUuid);
    }
}
