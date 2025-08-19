<?php

declare(strict_types=1);

namespace App\Market\Application;

class ItemResponse
{
    public function __construct(
        private string $id,
        private string $name,
        private float $weight,
        private string $type,
        private string $units = 'g'
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUnits(): string
    {
        return $this->units;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'weight' => $this->weight,
            'type' => $this->type,
            'units' => $this->units,
        ];
    }
}
