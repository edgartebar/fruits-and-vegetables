<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Fruit extends AggregateRoot
{
    public function __construct(
        private FruitId $id,
        private FruitName $name,
        private FruitWeight $weight
    )
    {
    }

    public static function create(FruitId $id, FruitName $name, FruitWeight $weight): self
    {
        return new self($id, $name, $weight);
    }

    public function getId(): FruitId
    {
        return $this->id;
    }

    public function getName(): FruitName
    {
        return $this->name;
    }

    public function getWeight(): FruitWeight
    {
        return $this->weight;
    }
}