<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Activity;

use Academy\Activity\Domain\Activity;
use Academy\Activity\Domain\ActivityName;
use Academy\Activity\Domain\ActivityUuid;

final class ActivityRepositoryMock extends ActivityRepositoryMockUnitTestCase
{
    public function getMockRepository()
    {
        $this->setUp();

        return $this->MockRepository();
    }

    public function getActivityUuid(): ActivityUuid
    {
        return $this->existingActivityUuid;
    }

    public function getActivityName(): ActivityName
    {
        return $this->existingActivityName;
    }

    public function shouldSearch(ActivityName $name, Activity $activity): void
    {
        $this->shouldSearchActivity($name, $activity);
    }
}