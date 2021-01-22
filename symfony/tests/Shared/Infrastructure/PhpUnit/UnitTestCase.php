<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Infrastructure\PhpUnit;

use Academy\Shared\Domain\Command;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

abstract class UnitTestCase extends MockeryTestCase
{
    public const LOGGER_TEST_NAME = 'test';

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function dispatch(Command $command, callable $commandHandler)
    {
        return $commandHandler($command);
    }
}
