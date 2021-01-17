<?php

declare(strict_types=1);

namespace Academy\Itinerary\Domain;

use Academy\Itinerary\Domain\Exception\ItineraryNotFound;
use Psr\Log\LoggerInterface;

final class ItineraryGuard implements IItineraryGuard
{
    private ItineraryRepository $itineraryRepository;
    private LoggerInterface $logger;

    public function __construct(
        ItineraryRepository $itineraryRepository,
        LoggerInterface $logger
    ) {
        $this->itineraryRepository = $itineraryRepository;
        $this->logger = $logger;
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @throws ItineraryNotFound
     */
    public function guard(
        ItineraryUuid $itineraryUuid
    ): void
    {
        $this->guardItineraryUuid($itineraryUuid);
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @throws ItineraryNotFound
     */
    private function guardItineraryUuid(ItineraryUuid $itineraryUuid): void
    {
        if (!$this->itineraryRepository->search($itineraryUuid)) {
            $this->logger->alert("Itinerary with uuid: {$itineraryUuid->value()} not found");
            throw new ItineraryNotFound($itineraryUuid->value());
        }
    }
}