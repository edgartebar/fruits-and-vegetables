<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Vegetable extends AggregateRoot
{

    public function __construct(
        private VegetableId $id,
        private VegetableName $name,
        private VegetableWeight $weight
    )
    {
    }

    public static function create(VegetableId $id, VegetableName $name, VegetableWeight $weight): self
    {
        $vegetable = new self($id, $name, $weight);

        return $vegetable;
    }

    public function getId(): VegetableId
    {
        return $this->id;
    }

    public function getName(): VegetableName
    {
        return $this->name;
    }

    public function getWeight(): VegetableWeight
    {
        return $this->weight;
    }
}