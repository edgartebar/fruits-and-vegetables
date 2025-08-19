<?php

namespace App\Tests\Unit\Market\Domain;

use App\Market\Application\ItemResponse;
use App\Market\Application\List\ListItemDto;
use App\Market\Application\Search\SearchItemDto;
use App\Market\Domain\AbstractItemCollection;
use App\Market\Domain\TypeEnum;
use App\Market\Domain\Vegetable;
use App\Market\Domain\VegetableCollection;
use App\Market\Domain\VegetableId;
use App\Market\Domain\VegetableRepository;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Market\SharedUtils\Factory\VegetableFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VegetableCollectionTest extends TestCase
{
    private MockObject $repository;

    private AbstractItemCollection $collection;

    public function setUp(): void
    {
        $this->repository = $this->createMock(VegetableRepository::class);
        $this->collection = new VegetableCollection(
            $this->repository
        );
    }

    public function testAdd(): void
    {
        $item = $this->createMock(Vegetable::class);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($item);

        $this->collection->add($item);
    }

    public function testRemoveWithExistingItem(): void
    {
        $itemId = $this->createMock(VegetableId::class);
        $item = $this->createMock(Vegetable::class);

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
        $itemId = $this->createMock(VegetableId::class);

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with($itemId)
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('vegetable with ID ');

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

        $item = VegetableFactory::createVegetable();
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
            TypeEnum::VEGETABLE_TYPE,
            null,
            'name',
            'asc',
            10,
            0,
            'g'
        );

        $item = VegetableFactory::createVegetable();

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
        $this->assertTrue($this->collection->supports(TypeEnum::VEGETABLE_TYPE));
    }
}