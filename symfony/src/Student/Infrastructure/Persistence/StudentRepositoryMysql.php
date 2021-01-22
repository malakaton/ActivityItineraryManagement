<?php

declare(strict_types=1);

namespace Academy\Student\Infrastructure\Persistence;

use Academy\Student\Domain\Student;
use Academy\Student\Domain\StudentRepository;
use Academy\Student\Domain\StudentUuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class StudentRepositoryMysql implements StudentRepository
{
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Student::class);
    }

    /**
     * @param StudentUuid $studentUuid
     * @return Student|null
     */
    public function search(StudentUuid $studentUuid): ?Student
    {
        $t = $this->repository->find($studentUuid);
    }
}