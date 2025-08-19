<?php

declare(strict_types=1);

namespace App\Market\Application\Search;

use App\Market\Application\ItemResponse;
use App\Market\Domain\FruitCollection;
use App\Market\Domain\VegetableCollection;

class SearchItemUseCase
{
    public function __construct(
        private \Traversable $collections
    )
    {
    }

    public function __invoke(SearchItemDto $dto)
    {
        $items = [];

        foreach ($this->collections as $collection) {
            if (null === $dto->getType() || $collection->supports($dto->getType())) {
                $items = array_merge($collection->search($dto), $items);
            }
        }

        return $items;
    }
}