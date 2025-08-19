<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

// todo: This logic needs to be moved to Collection objects
class ItemFactory
{
    public function createItem(
        string $name,
        int $weight,
        string $type,
        string $unit = 'g',
    ): AggregateRoot
    {
        if (!TypeEnum::isAValidValue($type)) {
            throw new \TypeError(\sprintf('The type <%s> is invalid', $type));
        }

        if ($type === TypeEnum::FRUIT_TYPE) {
            return Fruit::create(
                FruitId::random(),
                new FruitName($name),
                new FruitWeight($weight, $unit)
            );
        }

        if ($type === TypeEnum::VEGETABLE_TYPE) {
            return Vegetable::create(
                VegetableId::random(),
                new VegetableName($name),
                new VegetableWeight($weight, $unit)
            );
        }
    }
}