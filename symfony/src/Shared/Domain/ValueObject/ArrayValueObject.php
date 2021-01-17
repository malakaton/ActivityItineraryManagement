<?php

declare(strict_types=1);

namespace Academy\Shared\Domain\ValueObject;

abstract class ArrayValueObject
{
    protected array $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }

    public function __toArray(): array
    {
        return $this->value();
    }
}