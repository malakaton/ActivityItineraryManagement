<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Infrastructure\Persistence;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityLevel;
use Academy\Activity\Domain\ActivityUuid;
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
     * @return array|null
     */
    public function searchActivitiesByItineraryUuid(ItineraryUuid $itineraryUuid): ?array
    {
        return $this->repository->createQueryBuilder("ai")
                ->select('ai.position.value, a.name.value, a.level.value, a.time.value, a.solution.value')
                ->leftJoin(Activity::class, 'a', 'WITH', 'a.uuid=ai.activityUuid')
                ->where('ai.itineraryUuid = (:id)')
                ->orderBy('ai.position.value', 'ASC')
                ->setParameter('id', $itineraryUuid)
                ->getQuery()
                ->getResult();
    }

    public function getFirstActivityItineraryByLevel(
        ItineraryUuid $itineraryUuid,
        ActivityLevel $activityLevel
    ): ?array
    {
        return $this->repository->createQueryBuilder("ai")
            ->select('ai.position.value, a.name.value, a.level.value, a.time.value, a.solution.value')
            ->leftJoin(Activity::class, 'a', 'WITH', 'a.uuid=ai.activityUuid')
            ->where('ai.itineraryUuid = (:id)')
            ->andWhere('a.level.value = (:level)')
            ->orderBy('ai.position.value', 'ASC')
            ->setParameter('id', $itineraryUuid)
            ->setParameter('level', $activityLevel->value())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityItineraryPosition $activityPosition
     * @param ActivityLevel|null $activityLevel
     * @return array|null
     */
    public function getActivityItineraryByCriteria(
        ItineraryUuid $itineraryUuid,
        ActivityItineraryPosition $activityPosition,
        ActivityLevel $activityLevel = null
    ): ?array
    {
        $query = $this->repository->createQueryBuilder("ai")
            ->select('ai.position.value, a.name.value, a.level.value, a.time.value, a.solution.value')
            ->leftJoin(Activity::class, 'a', 'WITH', 'a.uuid=ai.activityUuid')
            ->where('ai.itineraryUuid = (:id)')
            ->andWhere('ai.position.value = (:position)')
            ->setParameter('id', $itineraryUuid)
            ->setParameter('position', $activityPosition->value());

        is_null($activityLevel) ?: $query->andWhere('a.level.value = (:level)')
            ->setParameter('level', $activityLevel->value());

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @return ActivityItineraryPosition
     */
    public function getNextPositionByItineraryUuid(ItineraryUuid $itineraryUuid): ActivityItineraryPosition
    {
        $position = $this->repository->createQueryBuilder("ai")
            ->select('ai.position.value as position')
            ->where('ai.itineraryUuid = (:id)')
            ->setParameter('id', $itineraryUuid)
            ->orderBy('ai.position.value', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()['position'] ?? self::FIRST_ORDER_ACTIVITY_ITINERARY;

        return new ActivityItineraryPosition($position + self::ADD_ORDER);
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityUuid $activityUuid
     * @return bool
     */
    public function isDuplicatedActivity(ItineraryUuid $itineraryUuid, ActivityUuid $activityUuid): bool
    {
        $result = $this->repository->findOneBy(['itineraryUuid' => $itineraryUuid, 'activityUuid' => $activityUuid]);

        return is_null($result) ? false : true;
    }
}