<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluateActivity;

use Academy\Shared\Domain\Command;

final class EvaluateActivityCommand implements Command
{
    private string $studentUuid;
    private string $itineraryUuid;
    private string $activityName;
    private string $answer;
    private int $invertedTime;

    public function __construct(
        string $studentUuid,
        string $itineraryUuid,
        string $activityName,
        string $answer,
        int $invertedTime
    )
    {
        $this->studentUuid = $studentUuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->activityName = $activityName;
        $this->answer = $answer;
        $this->invertedTime = $invertedTime;
    }

    public function studentUuid(): string
    {
        return $this->studentUuid;
    }

    public function itineraryUuid(): string
    {
        return $this->itineraryUuid;
    }

    public function activityName(): string
    {
        return $this->activityName;
    }

    public function answer(): string
    {
        return $this->answer;
    }

    public function invertedTime(): int
    {
        return $this->invertedTime;
    }
}
