<?php

declare(strict_types=1);

namespace App\Market\Application\List;

class ListItemUseCase
{
    public function __construct(
        private \Traversable $collections
    )
    {
    }

    public function __invoke(ListItemDto $dto): array
    {
        $items = [];

        foreach ($this->collections as $collection) {
            if (null === $dto->getType() || $collection->supports($dto->getType())) {
                $items = array_merge($collection->list($dto), $items);
            }
        }

        return $items;
    }
}