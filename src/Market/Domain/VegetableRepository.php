<?php

declare(strict_types=1);

namespace App\Market\Domain;

interface VegetableRepository
{
    public function find(VegetableId $id): ?Vegetable;

    public function save(Vegetable $vegetable): void;

    public function delete(Vegetable $vegetable): void;

    public function list(?int $gt = null, ?int $lt = null): array;

    public function search(?string $name = null, ?string $orderBy = null, ?string $order = null, ?int $limit = null, ?int $offset = null): array;
}
