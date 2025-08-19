<?php

namespace App\Tests\Unit\Market\Domain;

use App\Market\Application\List\ListItemDto;
use App\Market\Application\Search\SearchItemDto;
use App\Market\Domain\AbstractItemCollection;
use App\Market\Domain\Fruit;
use App\Market\Domain\FruitCollection;
use App\Market\Domain\FruitId;
use App\Market\Domain\FruitRepository;
use App\Market\Domain\TypeEnum;
use App\Tests\Unit\Market\SharedUtils\Factory\FruitFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FruitCollectionTest extends TestCase
{

    private MockObject $repository;

    private AbstractItemCollection $collection;

    public function setUp(): void
    {
        $this->repository = $this->createMock(FruitRepository::class);
        $this->collection = new FruitCollection(
            $this->repository
        );
    }

    public function testAdd(): void
    {
        $item = $this->createMock(Fruit::class);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($item);

        $this->collection->add($item);
    }

    public function testRemoveWithExistingItem(): void
    {
        $itemId = $this->createMock(FruitId::class);
        $item = $this->createMock(Fruit::class);

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with($itemId)
            ->willReturn($item);

        $this->repository
            ->expects($this->once())
            ->method('delete')
            ->with($item);

        $this->collection->remove($itemId);
    }

    public function testRemoveWithNonExistingItem(): void
    {
        $itemId = $this->createMock(FruitId::class);

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with($itemId)
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('fruit with ID ');

        $this->collection->remove($itemId);
    }

    public function testList(): void
    {
        $dto = new ListItemDto(
            null,
            null,
            null,
            'g'
        );

        $item = FruitFactory::createFruit();
        $this->repository
            ->expects($this->once())
            ->method('list')
            ->with(null, null)
            ->willReturn([$item]);

        $result = $this->collection->list($dto);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testSearch(): void
    {
        $dto = new SearchItemDto(
            TypeEnum::FRUIT_TYPE,
            null,
            'name',
            'asc',
            10,
            0,
            'g'
        );

        $item = FruitFactory::createFruit();

        $this->repository
            ->expects($this->once())
            ->method('search')
            ->with(null, 'name', 'asc', 10, 0)
            ->willReturn([$item]);

        $result = $this->collection->search($dto);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->collection->supports(TypeEnum::FRUIT_TYPE));
    }
}