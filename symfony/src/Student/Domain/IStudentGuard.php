<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

interface IStudentGuard
{
    public function guard(StudentUuid $studentUuid): void;
}