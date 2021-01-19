<?php

declare(strict_types=1);

namespace Academy\StudentItineraryProgress\Infrastructure\Persistence;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;
use Academy\StudentItineraryProgress\Domain\StudentItineraryProgress;
use Academy\StudentItineraryProgress\Domain\StudentItineraryProgressRepo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ObjectRepository;

final class StudentItineraryProgressRepoMysql implements StudentItineraryProgressRepo
{
    private ObjectRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(StudentItineraryProgress::class);
    }

    /**
     * @param ItineraryUuid $itineraryUuid
     * @param StudentUuid $studentUuid
     * @return ActivityName|null
     * @throws NonUniqueResultException
     */
    public function find(ItineraryUuid $itineraryUuid, StudentUuid $studentUuid): ?ActivityName
    {
        $activityName = $this->repository->createQueryBuilder("p")
            ->select('a.name.value as name')
            ->leftJoin(Activity::class, 'a', 'WITH', 'a.uuid=p.nextActivityUuid')
            ->where('p.itineraryUuid = (:itineraryUuid)')
            ->andWhere('p.studentUuid = (:studentUuid)')
            ->setParameter('itineraryUuid', $itineraryUuid)
            ->setParameter('studentUuid', $studentUuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()['name'] ?? '';

        return new ActivityName($activityName);
    }
}