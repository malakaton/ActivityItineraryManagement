<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Student;

use Academy\Student\Domain\StudentUuid;

final class StudentRepositoryMock extends StudentRepositoryMockUnitTestCase
{
    public function getMockRepository()
    {
        $this->setUp();

        return $this->MockRepository();
    }

    public function getStudentUuid(): StudentUuid
    {
        return $this->existingStudentUuid;
    }

    public function shouldSearch(StudentUuid $uuid): void
    {
        $this->shouldSearchStudent($uuid);
    }
}