<?php

declare(strict_types=1);

namespace App\Market\Application\List;

class ListItemDto
{
    public function __construct(
        private ?string $type = null,
        private ?int $gt = null,
        private ?int $lt = null,
        private ?string $units = 'g'
    ) {
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getLt(): ?int
    {
        return $this->lt;
    }

    public function getGt(): ?int
    {
        return $this->gt;
    }

    public function getUnits(): ?string
    {
        return $this->units;
    }
}