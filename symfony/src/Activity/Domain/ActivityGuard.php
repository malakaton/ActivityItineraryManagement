<?php

declare(strict_types=1);

namespace Academy\Activity\Domain;

use Academy\Activity\Domain\Exception\ActivityNotFound;
use Psr\Log\LoggerInterface;

final class ActivityGuard implements IActivityGuard
{
    private ?Activity $activity;
    private ActivityRepository $activityRepository;
    private LoggerInterface $logger;

    public function __construct(
        ActivityRepository $activityRepository,
        LoggerInterface $logger
    ) {
        $this->activityRepository = $activityRepository;
        $this->logger = $logger;
    }

    /**
     * @param ActivityId $activityId
     * @throws ActivityNotFound
     */
    public function guard(
        ActivityId $activityId
    ): void
    {
        $this->guardActivity($activityId);
    }

    /**
     * @param ActivityId $activityId
     * @throws ActivityNotFound
     */
    private function guardActivity(ActivityId $activityId): void
    {
        if (!$this->activity = $this->activityRepository->search($activityId)) {
            $this->logger->alert("Activity with name: {$activityId->value()} not found");
            throw new ActivityNotFound($activityId->value());
        }
    }

    public function get(): ?Activity
    {
        return $this->activity;
    }
}