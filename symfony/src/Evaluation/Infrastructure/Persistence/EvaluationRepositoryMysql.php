<?php

declare(strict_types=1);

namespace Academy\Evaluation\Infrastructure\Persistence;

use Academy\Evaluation\Domain\Evaluation;
use Academy\Evaluation\Domain\EvaluationRepository;
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
}