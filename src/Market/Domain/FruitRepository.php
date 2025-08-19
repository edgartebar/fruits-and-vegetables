<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Market\Domain\Fruit;
use App\Market\Domain\FruitId;

interface FruitRepository
{
    public function find(FruitId $id): ?Fruit;

    public function save(Fruit $fruit): void;

    public function delete(Fruit $fruit): void;

    public function list(?int $gt = null, ?int $lt = null): array;

    public function search(?string $name = null, ?string $orderBy = null, ?string $order = null, ?int $limit = null, ?int $offset = null): array;
}
