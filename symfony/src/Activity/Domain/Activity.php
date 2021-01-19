<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

final class Activity
{
    public const SEPARATOR_FOR_SOLUTION = '_';

    private ActivityUuid $uuid;
    private ActivityName $name;
    private ActivityLevel $level;
    private ActivityTime $time;
    private ActivitySolution $solution;

    public function __construct(
        ActivityUuid $uuid,
        ActivityName $name,
        ActivityLevel $level,
        ActivityTime $time,
        ActivitySolution $solution
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->level = $level;
        $this->time = $time;
        $this->solution = $solution;
    }

    public function uuid(): ActivityUuid
    {
        return $this->uuid;
    }


    public function name(): ActivityName
    {
        return $this->name;
    }

    public function level(): ActivityLevel
    {
        return $this->level;
    }

    public function time(): ActivityTime
    {
        return $this->time;
    }

    public function solution(): ActivitySolution
    {
        return $this->solution;
    }
}