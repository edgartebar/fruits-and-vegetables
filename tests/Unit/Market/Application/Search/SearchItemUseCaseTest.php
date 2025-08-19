<?php

declare(strict_types=1);

namespace App\Tests\Unit\Market\Application\Search;

use App\Market\Application\Search\SearchItemDto;
use App\Market\Application\Search\SearchItemUseCase;
use App\Shared\Domain\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SearchItemUseCaseTest extends TestCase
{
    private \Traversable $collections;
    private MockObject $collection1;

    private MockObject $collection2;

    private SearchItemUseCase $useCase;

    protected function setUp(): void
    {
        $this->collection1 = $this->createMock(Collection::class);
        $this->collection2 = $this->createMock(Collection::class);

        $this->collections = new \ArrayIterator([
            $this->collection1,
            $this->collection2,
        ]);

        $this->useCase = new SearchItemUseCase($this->collections);
    }

    public function testSearchAllTypesMergesFromAllCollections(): void
    {
        $dto = new SearchItemDto(null, 'ap', 'name', 'asc', 10, 0, 'g');

        $searchFromCollection1 = [
            ['id' => '1', 'name' => 'Apple', 'weight' => 150.0, 'type' => 'fruit', 'units' => 'g'],
        ];
        $searchFromCollection2 = [
            ['id' => '2', 'name' => 'Apricot', 'weight' => 120.0, 'type' => 'fruit', 'units' => 'g'],
        ];

        $this->collection1->expects($this->never())
            ->method('supports');
        $this->collection2->expects($this->never())
            ->method('supports');

        $this->collection1->expects($this->once())
            ->method('search')
            ->with($dto)
            ->willReturn($searchFromCollection1);

        $this->collection2->expects($this->once())
            ->method('search')
            ->with($dto)
            ->willReturn($searchFromCollection2);

        $result = ($this->useCase)($dto);

        $this->assertSame(
            array_merge($searchFromCollection2, $searchFromCollection1),
            $result
        );
    }

    public function testFiltersByTypeAndSearchesOnlyFromSupportingCollections(): void
    {
        $dto = new SearchItemDto('fruit', 'ap', 'name', 'asc', 10, 0, 'g');

        $searchFromCollection1 = [
            ['id' => '1', 'name' => 'Apple', 'weight' => 150.0, 'type' => 'fruit', 'units' => 'g'],
        ];

        $this->collection1->expects($this->once())
            ->method('supports')
            ->with('fruit')
            ->willReturn(true);

        $this->collection1->expects($this->once())
            ->method('search')
            ->with($dto)
            ->willReturn($searchFromCollection1);

        $this->collection2->expects($this->once())
            ->method('supports')
            ->with('fruit')
            ->willReturn(false);

        $this->collection2->expects($this->never())
            ->method('search');

        $result = ($this->useCase)($dto);

        $this->assertSame($searchFromCollection1, $result);
    }
} 