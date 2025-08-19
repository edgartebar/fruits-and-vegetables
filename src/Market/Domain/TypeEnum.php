<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\ValueObject\Enum;

class TypeEnum extends Enum
{
    const FRUIT_TYPE = 'fruit';

    const VEGETABLE_TYPE = 'vegetable';

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new \InvalidArgumentException(\sprintf('The type <%s> is invalid', $value));
    }
}