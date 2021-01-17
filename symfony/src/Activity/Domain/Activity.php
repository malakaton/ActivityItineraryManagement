<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

final class Activity
{
    private ActivityUuid $uuid;
    private ActivityName $name;
    private ActivityLevel $level;
    private ActivityTime $time;
    private ActivityAnswers $answers;

    public function __construct(
        ActivityUuid $uuid,
        ActivityName $name,
        ActivityLevel $level,
        ActivityTime $time,
        ActivityAnswers $answers
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->level = $level;
        $this->time = $time;
        $this->answers = $answers;
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

    public function answers(): ActivityAnswers
    {
        return $this->answers;
    }
}