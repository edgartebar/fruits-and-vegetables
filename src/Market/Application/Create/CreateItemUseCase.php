<?php

declare(strict_types=1);

namespace App\Market\Application\Create;

use App\Market\Domain\ItemFactory;

class CreateItemUseCase
{
    public function __construct(
        private ItemFactory $itemFactory,
        private \Traversable $collections
    )
    {
    }

    public function __invoke(CreateItemDto $createFruitDto): void
    {
        $item = $this->itemFactory->createItem(
            $createFruitDto->getName(),
            $createFruitDto->getWeight(),
            $createFruitDto->getType(),
            $createFruitDto->getUnit()
        );

        foreach ($this->collections as $collection) {
            if ($collection->supports($createFruitDto->getType())) {
                $collection->add($item);
                return;
            }
        }

    }
}