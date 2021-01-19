<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

interface StudentRepository
{
    public function search(StudentUuid $studentUuid): ?Student;
}