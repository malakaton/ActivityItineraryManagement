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
     * @return array
     */
    public function getEvaluationByStudentItineraryUuid(StudentUuid $studentUuid, ItineraryUuid $itineraryUuid): array
    {
        return $this->repository->createQueryBuilder("e")
            ->select('e.activityId, e.itineraryUuid, e.createDate.value, e.studentUuid, e.createDate.value, e.answer.value, e.invertedTime.value, e.score.value, e.percentageInvertedTime.value')
            ->where('e.studentUuid = (:studentUuid)')
            ->andWhere('e.itineraryUuid = (:itineraryUuid)')
            ->setParameter('studentUuid', $studentUuid)
            ->setParameter('itineraryUuid', $itineraryUuid)
            ->getQuery()
            ->getResult();

    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @return array|null
     */
    public function getLastStudentEvaluation(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): ?array {
        return $this->repository->createQueryBuilder("e")
            ->select('e.activityId, e.itineraryUuid, e.createDate.value, e.studentUuid, a.level.value, ai.position.value, e.score.value, e.percentageInvertedTime.value')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.activityId=e.activityId AND ai.itineraryUuid=e.itineraryUuid')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.id=e.activityId')
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
     */
    public function getStudentActivityEvaluatedByItineraryPosition(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityItineraryPosition $activityItineraryPosition
    ) : ?array
    {
        return $this->repository->createQueryBuilder("e")
            ->select('ai.activityId, ai.itineraryUuid, a.level.value, ai.position.value')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.itineraryUuid=e.itineraryUuid')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.id=ai.activityId')
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
     */
    public function getLastStudentActivityEvaluatedByLevel(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid,
        ActivityLevel $activityLevel
    ) : ?array
    {
        return $this->repository->createQueryBuilder("e")
            ->select('e.activityId, e.itineraryUuid, a.level.value, ai.position.value')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.id=e.activityId')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.itineraryUuid=e.itineraryUuid AND ai.activityId = a.id')
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