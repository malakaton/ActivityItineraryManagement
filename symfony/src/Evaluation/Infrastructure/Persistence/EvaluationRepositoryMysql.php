<?php

declare(strict_types=1);

namespace Academy\Evaluation\Infrastructure\Persistence;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityLevel;
use Academy\ActivityItinerary\Domain\ActivityItinerary;
use Academy\ActivityItinerary\Domain\ActivityItineraryPosition;
use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationRepository;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\StudentUuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ObjectRepository;

final class EvaluationRepositoryMysql implements EvaluationRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Evaluation::class);
    }

    /**
     * @param Evaluation $evaluation
     */
    public function save(Evaluation $evaluation): void
    {
        $this->entityManager->persist($evaluation);

        $this->entityManager->flush();
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getLastStudentEvaluation(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): ?array {
        return $this->repository->createQueryBuilder("e")
            ->select('e.activityUuid, e.itineraryUuid, e.createDate.value, e.studentUuid, a.name.value, a.level.value, ai.position.value, e.score.value, e.percentageInvertedTime.value')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.activityUuid=e.activityUuid AND ai.itineraryUuid=e.itineraryUuid')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.uuid=e.activityUuid')
            ->where('e.studentUuid = (:studentUuid)')
            ->andWhere('e.itineraryUuid = (:itineraryUuid)')
            ->orderBy('e.createDate.value', 'DESC')
            ->setParameter('studentUuid', $studentUuid)
            ->setParameter('itineraryUuid', $itineraryUuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityItineraryPosition $activityItineraryPosition
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getStudentActivityEvaluatedByItineraryPosition(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityItineraryPosition $activityItineraryPosition
    ) : ?array
    {
        return $this->repository->createQueryBuilder("e")
            ->select('ai.activityUuid, ai.itineraryUuid, a.name.value, a.level.value, ai.position.value')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.itineraryUuid=e.itineraryUuid')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.uuid=ai.activityUuid')
            ->where('e.studentUuid = (:studentUuid)')
            ->andWhere('e.itineraryUuid = (:itineraryUuid)')
            ->andWhere('ai.position.value = (:position)')
            ->orderBy('e.createDate.value', 'DESC')
            ->setParameter('studentUuid', $studentUuid)
            ->setParameter('itineraryUuid', $itineraryUuid)
            ->setParameter('position', $activityItineraryPosition->value())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @param ActivityLevel $activityLevel
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getLastStudentActivityEvaluatedByLevel(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityLevel $activityLevel
    ) : ?array
    {
        return $this->repository->createQueryBuilder("e")
            ->select('e.activityUuid, e.itineraryUuid, a.name.value, a.level.value, ai.position.value')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.uuid=e.activityUuid')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.itineraryUuid=e.itineraryUuid AND ai.activityUuid = a.uuid')
            ->where('e.studentUuid = (:studentUuid)')
            ->andWhere('e.itineraryUuid = (:itineraryUuid)')
            ->andWhere('a.level.value = (:level)')
            ->orderBy('ai.position.value', 'DESC')
            ->setParameter('studentUuid', $studentUuid)
            ->setParameter('itineraryUuid', $itineraryUuid)
            ->setParameter('level', $activityLevel->value())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}