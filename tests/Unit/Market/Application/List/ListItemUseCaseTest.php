<?php

declare(strict_types=1);

namespace App\Tests\Unit\Market\Application\List;

use App\Market\Application\List\ListItemDto;
use App\Market\Application\List\ListItemUseCase;
use App\Shared\Domain\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListItemUseCaseTest extends TestCase
{
    private \Traversable $collections;

    /** @var MockObject&Collection */
    private MockObject $collection1;

    /** @var MockObject&Collection */
    private MockObject $collection2;

    private ListItemUseCase $useCase;

    protected function setUp(): void
    {
        $this->collection1 = $this->createMock(Collection::class);
        $this->collection2 = $this->createMock(Collection::class);

        $this->collections = new \ArrayIterator([
            $this->collection1,
            $this->collection2,
        ]);

        $this->useCase = new ListItemUseCase($this->collections);
    }

    public function testListAllTypesMergesFromAllCollections(): void
    {
        $dto = new ListItemDto(null, 100, 300, 'g');

        $listFromCollection1 = [
            ['id' => '1', 'name' => 'Apple', 'weight' => 150.0, 'type' => 'fruit', 'units' => 'g'],
        ];
        $listFromCollection2 = [
            ['id' => '2', 'name' => 'Carrot', 'weight' => 100.0, 'type' => 'vegetable', 'units' => 'g'],
        ];

        $this->collection1->expects($this->never())
            ->method('supports');
        $this->collection2->expects($this->never())
            ->method('supports');

        $this->collection1->expects($this->once())
            ->method('list')
            ->with($dto)
            ->willReturn($listFromCollection1);

        $this->collection2->expects($this->once())
            ->method('list')
            ->with($dto)
            ->willReturn($listFromCollection2);

        $result = ($this->useCase)($dto);

        $this->assertSame(
            array_merge($listFromCollection2, $listFromCollection1),
            $result
        );
    }

    public function testFiltersByTypeAndListsOnlyFromSupportingCollections(): void
    {
        $dto = new ListItemDto('fruit', null, null, 'g');

        $listFromCollection1 = [
            ['id' => '1', 'name' => 'Apple', 'weight' => 150.0, 'type' => 'fruit', 'units' => 'g'],
        ];

        $this->collection1->expects($this->once())
            ->method('supports')
            ->with('fruit')
            ->willReturn(true);

        $this->collection1->expects($this->once())
            ->method('list')
            ->with($dto)
            ->willReturn($listFromCollection1);

        $this->collection2->expects($this->once())
            ->method('supports')
            ->with('fruit')
            ->willReturn(false);

        $this->collection2->expects($this->never())
            ->method('list');

        $result = ($this->useCase)($dto);

        $this->assertSame($listFromCollection1, $result);
    }
} 