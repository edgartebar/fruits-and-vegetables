<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Persistence\Doctrine;

use App\Market\Domain\FruitId;
use App\Shared\Infrastructure\Persistence\Doctrine\UuidType;

class FruitIdType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'fruit_id';
    }

    protected function typeClassName(): string
    {
        return FruitId::class;
    }
}
