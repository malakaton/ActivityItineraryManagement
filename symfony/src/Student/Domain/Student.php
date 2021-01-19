<?php

declare(strict_types=1);

namespace Academy\Student\Domain;

final class Student
{
    private StudentUuid $uuid;
    private StudentName $name;

    public function __construct(
        StudentUuid $uuid,
        StudentName $name
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function uuid(): StudentUuid
    {
        return $this->uuid;
    }

    public function name(): StudentName
    {
        return $this->name;
    }
}