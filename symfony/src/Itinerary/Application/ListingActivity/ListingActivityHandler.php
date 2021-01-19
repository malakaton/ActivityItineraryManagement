<?php

declare(strict_types=1);

namespace Academy\Itinerary\Application\ListingActivity;

use Academy\ActivityItinerary\Domain\ActivityFinder;
use Academy\Itinerary\Domain\ItineraryUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ListingActivityHandler implements MessageHandlerInterface
{
    private ActivityFinder $activityFinder;

    public function __construct(ActivityFinder $activityFinder)
    {
        $this->activityFinder = $activityFinder;
    }

    /**
     * @param ListingActivityCommand $command
     * @return array|null
     * @throws \JsonException
     */
    public function __invoke(ListingActivityCommand $command): ?array
    {
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());

        return $this->activityFinder->__invoke($itineraryUuid);
    }
}
