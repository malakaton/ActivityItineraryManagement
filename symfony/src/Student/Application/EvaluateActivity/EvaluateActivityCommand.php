<?php

declare(strict_types=1);

namespace Academy\Student\Application\EvaluateActivity;

use Academy\Shared\Domain\Command;

final class EvaluateActivityCommand implements Command
{
    private string $studentUuid;
    private string $itineraryUuid;
    private string $activityId;
    private string $answer;
    private int $invertedTime;

    public function __construct(
        string $studentUuid,
        string $itineraryUuid,
        string $activityId,
        string $answer,
        int $invertedTime
    )
    {
        $this->studentUuid = $studentUuid;
        $this->itineraryUuid = $itineraryUuid;
        $this->activityId = $activityId;
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

    public function activityId(): string
    {
        return $this->activityId;
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
