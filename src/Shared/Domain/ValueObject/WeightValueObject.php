<?php

namespace App\Shared\Domain\ValueObject;

class WeightValueObject extends IntValueObject
{
    public function __construct(int $value, string $unit = 'g')
    {
        if ($unit === 'kg') {
            $value *= 1000;
        } elseif ($unit !== 'g') {
            throw new \InvalidArgumentException('Invalid weight unit. Use "g" or "kg".');
        }

        parent::__construct($value);
    }

    public function toKg(): float
    {
        return $this->value / 1000.0;
    }
}