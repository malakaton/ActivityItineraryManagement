<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

interface ActivityRepository
{
    public function searchByName(ActivityName $activityName): ?Activity;
}