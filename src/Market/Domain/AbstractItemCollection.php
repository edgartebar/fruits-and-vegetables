<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Market\Application\ItemResponse;
use App\Market\Application\List\ListItemDto;
use App\Market\Application\Search\SearchItemDto;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Collection;
use App\Shared\Domain\ValueObject\Uuid;

abstract class AbstractItemCollection implements Collection
{
    abstract protected function getSupportType(): string;
    abstract protected function getRepository(): object;

    public function add(AggregateRoot $item): void
    {
        $this->getRepository()->save($item);
    }

    public function remove(Uuid $itemId): void
    {
        $item = $this->getRepository()->find($itemId);

        if (null === $item) {
            $itemClassName = $this->getSupportType();
            throw new \InvalidArgumentException(sprintf('%s with ID %s not found.', $itemClassName, $itemId->value()));
        }

        $this->getRepository()->delete($item);
    }

    public function list(ListItemDto $dto): array
    {
        $items = $this->getRepository()->list($dto->getGt(), $dto->getLt());

        return array_map(
            fn($item) => (new ItemResponse(
                $item->getId()->value(),
                $item->getName()->value(),
                $dto->getUnits() === 'g' ? $item->getWeight()->value() : $item->getWeight()->toKg(),
                $this->getSupportType(),
                $dto->getUnits()
            )
            )->toArray(),
            $items
        );
    }

    public function search(SearchItemDto $dto): array
    {
        $items = $this->getRepository()->search(
            $dto->getName(),
            $dto->getOrderBy(),
            $dto->getOrder(),
            $dto->getLimit(),
            $dto->getOffset()
        );

        return array_map(
            fn($item) => (new ItemResponse(
                $item->getId()->value(),
                $item->getName()->value(),
                $dto->getUnits() === 'g' ? $item->getWeight()->value() : $item->getWeight()->toKg(),
                $this->getSupportType(),
                $dto->getUnits()
            )
            )->toArray(),
            $items
        );
    }

    public function supports(string $type): bool
    {
        return $this->getSupportType() === $type;
    }
} 