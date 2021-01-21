<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Domain;

final class DateTimeMother
{
    public static function random(): \DateTime
    {
        return MotherCreator::random()->dateTime;
    }
}