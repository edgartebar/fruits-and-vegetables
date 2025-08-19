<?php

declare(strict_types=1);

namespace App\Tests\Unit\Market\Application\Create;

use App\Market\Application\Create\CreateItemDto;
use App\Market\Application\Create\CreateItemUseCase;
use App\Market\Domain\ItemFactory;
use App\Tests\Unit\Market\SharedUtils\Factory\FruitFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Shared\Domain\Collection;

class CreateItemUseCaseTest extends TestCase
{
    private MockObject $itemFactory;
    private \Traversable $collections;

    private MockObject $collection1;
    private MockObject $collection2;

    private CreateItemUseCase $useCase;

    protected function setUp(): void
    {
        $this->itemFactory = $this->createMock(ItemFactory::class);
        $this->collection1 = $this->createMock(Collection::class);
        $this->collection2 = $this->createMock(Collection::class);

        $this->collections = new \ArrayIterator([
            $this->collection1,
            $this->collection2
        ]);

        $this->useCase = new CreateItemUseCase($this->itemFactory, $this->collections);
    }

    public function testFruitCreation(): void
    {
        $createFruitDto = new CreateItemDto(
            'Apple',
            150,
            'fruit'
        );

        $fruit = FruitFactory::createFruit();

        $this->itemFactory->expects($this->once())
            ->method('createItem')
            ->with(
                'Apple',
                150,
                'fruit',
                'g'
            )
            ->willReturn($fruit);

        $this->collection1->expects($this->once())
            ->method('supports')
            ->with('fruit')
            ->willReturn(true);

        $this->collection1->expects($this->once())
            ->method('add')
            ->with($fruit);

        $this->collection2->expects($this->never())
            ->method('supports');

        $this->useCase->__invoke($createFruitDto);
    }

}