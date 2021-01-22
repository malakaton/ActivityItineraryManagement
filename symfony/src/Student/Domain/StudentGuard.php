<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

use Academy\Student\Domain\Exception\StudentNotFound;
use Psr\Log\LoggerInterface;

final class StudentGuard implements IStudentGuard
{
    private StudentRepository $studentRepository;
    private LoggerInterface $logger;

    public function __construct(
        StudentRepository $studentRepository,
        LoggerInterface $logger
    ) {
        $this->studentRepository = $studentRepository;
        $this->logger = $logger;
    }

    /**
     * @param StudentUuid $studentUuid
     * @throws StudentNotFound
     */
    public function guard(
        StudentUuid $studentUuid
    ): void
    {
        $this->guardStudentUuid($studentUuid);
    }

    /**
     * @param StudentUuid $studentUuid
     * @throws StudentNotFound
     */
    private function guardStudentUuid(StudentUuid $studentUuid): void
    {
        if (!$pepe =$this->studentRepository->search($studentUuid)) {
            $this->logger->alert("Student with uuid: {$studentUuid->value()} not found");
            throw new StudentNotFound($studentUuid->value());
        }
    }
}