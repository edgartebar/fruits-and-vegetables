<?php

declare(strict_types=1);

namespace App\Market\Domain;

class FruitCollection extends AbstractItemCollection
{
    const SUPPORT_TYPE = TypeEnum::FRUIT_TYPE;

    public function __construct(private FruitRepository $repository)
    {
    }

    protected function getSupportType(): string
    {
        return self::SUPPORT_TYPE;
    }

    protected function getRepository(): object
    {
        return $this->repository;
    }
}