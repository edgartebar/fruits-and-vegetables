<?php

declare(strict_types=1);

namespace App\Market\Domain;

class VegetableCollection extends AbstractItemCollection
{
    const SUPPORT_TYPE = 'vegetable';

    public function __construct(private VegetableRepository $repository)
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