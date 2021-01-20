<?php

declare(strict_types=1);

namespace Academy\Evaluation\Infrastructure\Persistence;

use Academy\Activity\Domain\Activity;
use Academy\ActivityItinerary\Domain\ActivityItinerary;
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

    public function getLastStudentEvaluation(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): ?array {
        return $this->repository->createQueryBuilder("e")
            ->select('e.activityUuid, a.name.value, a.level.value, ai.position.value, e.score.value, e.scoreInvertedTime.value')
            ->innerJoin(ActivityItinerary::class, 'ai', 'WITH', 'ai.activityUuid=e.activityUuid AND ai.itineraryUuid=e.itineraryUuid')
            ->innerJoin(Activity::class, 'a', 'WITH', 'a.uuid=e.activityUuid')
            ->where('e.studentUuid = (:studentUuid)')
            ->andWhere('e.itineraryUuid = (:itineraryUuid)')
            ->orderBy('ai.position.value', 'DESC')
            ->setParameter('studentUuid', $studentUuid)
            ->setParameter('itineraryUuid', $itineraryUuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}