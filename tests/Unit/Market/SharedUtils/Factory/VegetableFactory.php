<?php

namespace App\Tests\Unit\Market\SharedUtils\Factory;

use App\Market\Domain\Vegetable;
use App\Market\Domain\VegetableId;
use App\Market\Domain\VegetableName;
use App\Market\Domain\VegetableWeight;

class VegetableFactory
{
    public static function createVegetable(
        VegetableId $vegetableId = null,
    ): Vegetable {
        return new Vegetable(
            $vegetableId ?: self::createVegetableId(),
            self::createVegetableName(),
            self::createVegetableWeight(),
        );
    }

    public static function createVegetableId(): VegetableId
    {
        return new VegetableId('f46ca9d1-4bef-429e-90d3-7441695b59bb');
    }

    public static function createVegetableName(string $value = 'Vegetable name'): VegetableName
    {
        return new VegetableName($value);
    }

    public static function createVegetableWeight(int $value = 2000): VegetableWeight
    {
        return new VegetableWeight($value);
    }
}