<?php

declare(strict_types=1);

namespace Academy\Shared\Domain\ValueObject;

abstract class DateTimeValueObject
{
    protected \DateTime $value;

    public function __construct(\DateTime $value)
    {
        $this->value = $value;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public static function getDateTimeNow(): ?\DateTime
    {
        return new \DateTime('now');
    }

    public function value(): \DateTime
    {
        return $this->value;
    }
}