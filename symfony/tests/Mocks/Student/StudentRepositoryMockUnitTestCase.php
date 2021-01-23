<?php

declare(strict_types=1);

namespace Academy\Tests\Mocks\Student;

use Academy\Student\Domain\StudentRepository;
use Academy\Student\Domain\StudentUuid;
use Academy\Tests\Student\Domain\StudentMother;
use Academy\Tests\Student\Domain\StudentNameMother;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Academy\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class StudentRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository StudentRepository|MockInterface
     */
    private $repository;

    protected StudentUuid $existingStudentUuid;

    protected function setUp(): void
    {
        $this->existingStudentUuid = $this->getExistingStudentUuid();
    }

    protected function getExistingStudentUuid(): StudentUuid
    {
        return new StudentUuid(StudentUuidMother::stub_uuid);
    }


    protected function shouldSearchStudent(StudentUuid $uuid): void
    {
        $this->MockRepository()
            ->shouldReceive('search')
            ->with(\Mockery::on(function($argument) use ($uuid) {
                $this->assertInstanceOf(StudentUuid::class, $argument);
                $this->assertSame($this->existingStudentUuid->value(), $argument->value());
                $this->assertEquals($argument->value(), $uuid->value());

                return true;
            }))
            ->once()
            ->andReturn(StudentMother::fromRequest($uuid, StudentNameMother::random()));
    }

    /** @return StudentRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(StudentRepository::class);
    }
}