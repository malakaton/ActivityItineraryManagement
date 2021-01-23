<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

final class Activity
{
    public const SEPARATOR_FOR_SOLUTION = '_';

    private ActivityId $id;
    private ActivityName $name;
    private ActivityLevel $level;
    private ActivityTime $time;
    private ActivitySolution $solution;

    public function __construct(
        ActivityId $id,
        ActivityName $name,
        ActivityLevel $level,
        ActivityTime $time,
        ActivitySolution $solution
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->time = $time;
        $this->solution = $solution;
    }

    public function id(): ActivityId
    {
        return $this->id;
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