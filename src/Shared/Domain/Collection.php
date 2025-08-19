<?php

namespace App\Shared\Domain;

use App\Market\Application\List\ListItemDto;
use App\Market\Application\Search\SearchItemDto;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;

interface Collection
{
    public function add(AggregateRoot $item): void;

    public function remove(Uuid $itemId): void;

    public function list(ListItemDto $dto): array;

    public function search(SearchItemDto $dto): array;

    public function supports(string $type): bool;
}