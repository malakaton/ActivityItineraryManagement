<?php

declare(strict_types=1);

namespace Academy\Itinerary\Infrastructure\Persistence;

use Academy\Itinerary\Domain\Itinerary;
use Academy\Itinerary\Domain\ItineraryRepository;
use Academy\Itinerary\Domain\ItineraryUuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ItineraryRepositoryMysql implements ItineraryRepository
{
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Itinerary::class);
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @return Itinerary|null
     */
    public function search(ItineraryUuid $itineraryUuid): ?Itinerary
    {
        return $this->repository->find($itineraryUuid);
    }
}