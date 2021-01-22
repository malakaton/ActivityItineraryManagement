<?php

declare(strict_types=1);

namespace Academy\Tests\Student\Domain;

use Academy\Student\Domain\StudentName;
use Academy\Tests\Shared\Domain\StringMother;

final class StudentNameMother
{
    public static function create(string $value): StudentName
    {
        return new StudentName($value);
    }

    public static function random(): StudentName
    {
        return self::create(StringMother::random());
    }
}