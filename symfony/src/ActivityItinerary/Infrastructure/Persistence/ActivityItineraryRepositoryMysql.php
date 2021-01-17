<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Infrastructure\Persistence;

use Academy\ActivityItinerary\Domain\ActivityItinerary;
use Academy\ActivityItinerary\Domain\ActivityItineraryPosition;
use Academy\ActivityItinerary\Domain\ActivityItineraryRepository;
use Academy\Itinerary\Domain\ItineraryUuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ActivityItineraryRepositoryMysql implements ActivityItineraryRepository
{
    private const FIRST_ORDER_ACTIVITY_ITINERARY = 0;
    private const ADD_ORDER = 1;

    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(ActivityItinerary::class);
    }

    /**
     * @param ActivityItinerary $activityItinerary
     */
    public function save(ActivityItinerary $activityItinerary): void
    {
        $this->entityManager->persist($activityItinerary);

        $this->entityManager->flush();
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @return ActivityItinerary|null
     */
    public function searchByItineraryUuid(ItineraryUuid $itineraryUuid): ?ActivityItinerary
    {
        $t = $this->repository->findBy(['itinerary_uuid' => $itineraryUuid]);

        return null;
    }

    public function getNextPositionByItineraryUuid(ItineraryUuid $itineraryUuid): ActivityItineraryPosition
    {
        $position = $this->repository->createQueryBuilder("ai")
            ->select('position.value')
            ->where('ai.itineraryUuid = (:id)')
            ->orderBy('ai.position.value', 'DESC')
            ->setParameter('id', $itineraryUuid)
            ->getQuery()
            ->getFirstResult() ?? self::FIRST_ORDER_ACTIVITY_ITINERARY;

        return new ActivityItineraryPosition($position + self::ADD_ORDER);
    }
}