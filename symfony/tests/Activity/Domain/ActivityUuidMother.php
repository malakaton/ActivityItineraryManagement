<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityUuid;
use Academy\Tests\Shared\Domain\UuidMother;

final class ActivityUuidMother
{
    public const stub_uuid = '70f066f6-1cb7-4c45-97e2-287f0258ba02';

    public static function create(string $value): ActivityUuid
    {
        return new ActivityUuid($value);
    }

    public static function random(): ActivityUuid
    {
        return self::create(UuidMother::random());
    }

    public static function getByActivityName(ActivityName $name): ActivityUuid
    {
        $uuid = [
            'A1' => '70f066f6-1cb7-4c45-97e2-287f0258ba02',
            'A2' => '70f066f6-1cb7-4c45-97e2-287f0258ba03',
            'A3' => '70f066f6-1cb7-4c45-97e2-287f0258ba04',
            'A4' => '70f066f6-1cb7-4c45-97e2-287f0258ba05',
            'A5' => '70f066f6-1cb7-4c45-97e2-287f0258ba06',
            'A6' => '70f066f6-1cb7-4c45-97e2-287f0258ba07',
            'A7' => '70f066f6-1cb7-4c45-97e2-287f0258ba08',
            'A8' => '70f066f6-1cb7-4c45-97e2-287f0258ba09',
            'A9' => '70f066f6-1cb7-4c45-97e2-287f0258ba10',
            'A10' => '70f066f6-1cb7-4c45-97e2-287f0258ba11',
            'A11' => '70f066f6-1cb7-4c45-97e2-287f0258ba12',
            'A12' => '70f066f6-1cb7-4c45-97e2-287f0258ba13',
            'A13' => '70f066f6-1cb7-4c45-97e2-287f0258ba14',
            'A14' => '70f066f6-1cb7-4c45-97e2-287f0258ba15',
            'A15' => '70f066f6-1cb7-4c45-97e2-287f0258ba16',
        ];

        return self::create($uuid[$name->value()]);
    }
}