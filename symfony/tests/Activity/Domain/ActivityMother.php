<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityLevel;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivitySolution;
use Academy\Activity\Domain\ActivityTime;
use Academy\Activity\Domain\ActivityUuid;

final class ActivityMother
{
    public static function create(
        ActivityUuid $uuid,
        ActivityName $name,
        ActivityLevel $level,
        ActivityTime $time,
        ActivitySolution $solution
    ): Activity
    {
        return new Activity(
            $uuid,
            $name,
            $level,
            $time,
            $solution
        );
    }

    public static function fromRequest(
        ActivityName $activityName
    ): Activity
    {
        return self::create(
            ActivityUuidMother::getByActivityName($activityName),
            ActivityNameMother::create($activityName->value()),
            ActivityLevelMother::getByActivityName($activityName),
            ActivityTimeMother::getByActivityName($activityName),
            ActivitySolutionMother::getByActivityName($activityName)
        );
    }

    public static function random(): Activity
    {
        return self::create(
            ActivityUuidMother::random(),
            ActivityNameMother::random(),
            ActivityLevelMother::random(),
            ActivityTimeMother::random(),
            ActivitySolutionMother::random()
        );
    }
}