<?php

declare(strict_types=1);

namespace App\Market\Application\Create;

class CreateItemDto
{
    public function __construct(
        private string $name,
        private int $weight,
        private string $type,
        private string $unit = 'g',
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getType(): string
    {
        return $this->type;
    }
}