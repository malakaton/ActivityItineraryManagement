<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

interface IActivityGuard
{
    public function guard(ActivityName $activityName): void;
    public function getActivity(): ?Activity;
}