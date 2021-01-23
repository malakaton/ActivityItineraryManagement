<?php

declare(strict_types=1);

namespace Academy\Tests\Activity\Domain;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityId;
use Academy\Activity\Domain\ActivityLevel;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivitySolution;
use Academy\Activity\Domain\ActivityTime;

final class ActivityMother
{
    public static function create(
        ActivityId $uuid,
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
        ActivityId $activityId
    ): Activity
    {
        return self::create(
            $activityId,
            ActivityNameMother::random(),
            ActivityLevelMother::getByActivityId($activityId),
            ActivityTimeMother::getByActivityId($activityId),
            ActivitySolutionMother::getByActivityId($activityId)
        );
    }

    public static function random(): Activity
    {
        return self::create(
            ActivityIdMother::random(),
            ActivityNameMother::random(),
            ActivityLevelMother::random(),
            ActivityTimeMother::random(),
            ActivitySolutionMother::random()
        );
    }
}