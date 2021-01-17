<?php

declare(strict_types=1);

namespace Academy\Shared\Domain\ValueObject;

abstract class JsonValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toArray(): array
    {
        return json_decode($this->value(), true, 512, JSON_THROW_ON_ERROR);
    }
}