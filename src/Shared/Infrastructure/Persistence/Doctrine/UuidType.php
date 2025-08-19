<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shared\Domain\ValueObject\Uuid;

abstract class UuidType extends StringType
{
    abstract protected function typeClassName(): string;

    public function getName(): string
    {
        return static::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        if (null === $value) {
            return null;
        }

        return new $className($value);
    }

    /**
     * @var Uuid
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return \is_object($value) && \method_exists($value, 'value')
            ? $value->value()
            : $value;
    }
}
