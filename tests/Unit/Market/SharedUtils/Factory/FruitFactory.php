<?php

namespace App\Tests\Unit\Market\SharedUtils\Factory;

use App\Market\Domain\Fruit;
use App\Market\Domain\FruitId;
use App\Market\Domain\FruitName;
use App\Market\Domain\FruitWeight;

class FruitFactory
{
    public static function createFruit(
        FruitId $fruitId = null,
    ): Fruit {
        return new Fruit(
            $fruitId ?: self::createFruitId(),
            self::createFruitName(),
            self::createFruitWight(),
        );
    }

    public static function createFruitId(): FruitId
    {
        return new FruitId('f46ca9d1-4bef-429e-90d3-7441695b59bb');
    }

    public static function createFruitName(string $value = 'Fruit name'): FruitName
    {
        return new FruitName($value);
    }

    public static function createFruitWight(int $value = 2000): FruitWeight
    {
        return new FruitWeight($value);
    }
}