<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = \trim($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function equals(StringValueObject $other): bool
    {
        return $this->value() === $other->value();
    }
}
