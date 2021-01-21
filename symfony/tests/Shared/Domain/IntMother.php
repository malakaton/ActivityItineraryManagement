<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Domain;

final class IntMother
{
    public static function random(): int
    {
        return MotherCreator::random()->randomNumber(5);
    }
}