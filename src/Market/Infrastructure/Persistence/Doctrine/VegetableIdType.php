<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Persistence\Doctrine;

use App\Market\Domain\VegetableId;
use App\Shared\Infrastructure\Persistence\Doctrine\UuidType;

class VegetableIdType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'vegetable_id';
    }

    protected function typeClassName(): string
    {
        return VegetableId::class;
    }
}
