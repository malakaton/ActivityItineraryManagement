<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Domain;

use Academy\Student\Domain\Student;
use Academy\Student\Domain\StudentName;
use Academy\Student\Domain\StudentUuid;

final class StudentMother
{
    public static function create(
        StudentUuid $uuid,
        StudentName $name
    ): Student
    {
        return new Student(
            $uuid,
            $name
        );
    }

    public static function fromRequest(
        StudentUuid $uuid,
        StudentName $name
    ): Student
    {
        return self::create(
            StudentUuidMother::create($uuid->value()),
            StudentNameMother::create($name->value()),
        );
    }

    public static function random(): Student
    {
        return self::create(
            StudentUuidMother::random(),
            StudentNameMother::random(),
        );
    }
}