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
     * @param ActivityName $activityName
     * @throws ActivityNotFound
     */
    public function guard(
        ActivityName $activityName
    ): void
    {
        $this->guardActivityName($activityName);
    }

    /**
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param ActivityName $activityName
     * @throws ActivityNotFound
     */
    private function guardActivityName(ActivityName $activityName): void
    {
        if (!$this->activity = $this->activityRepository->searchByName($activityName)) {
            $this->logger->alert("Activity with name: {$activityName->value()} not found");
            throw new ActivityNotFound($activityName->value());
        }
    }
}