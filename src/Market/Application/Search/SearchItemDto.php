<?php

declare(strict_types=1);

namespace App\Market\Application\Search;

class SearchItemDto
{
    public function __construct(
        private ?string $type = null,
        private ?string $name = null,
        private ?string $orderBy = null,
        private ?string $order = null,
        private ?int    $limit = null,
        private ?int    $offset = null,
        private ?string $units = 'g'
    )
    {
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getUnits(): ?string
    {
        return $this->units;
    }
}