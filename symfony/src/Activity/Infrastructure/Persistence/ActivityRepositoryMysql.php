<?php

declare(strict_types=1);

namespace Academy\Activity\Infrastructure\Persistence;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityId;
use Academy\Activity\Domain\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ActivityRepositoryMysql implements ActivityRepository
{
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Activity::class);
    }

    /**
     * @param ActivityId $activityId
     * @return Activity|null
     */
    public function search(ActivityId $activityId): ?Activity
    {
        return $this->repository->find($activityId);
    }
}