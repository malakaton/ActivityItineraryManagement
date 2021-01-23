<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

interface IActivityGuard
{
    public function guard(ActivityId $activityId): void;
}