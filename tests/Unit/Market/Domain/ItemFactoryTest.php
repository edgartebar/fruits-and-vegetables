<?php

declare(strict_types=1);

namespace App\Tests\Unit\Market\Domain;

use App\Market\Domain\Fruit;
use App\Market\Domain\ItemFactory;
use App\Market\Domain\Vegetable;
use PHPUnit\Framework\TestCase;

class ItemFactoryTest extends TestCase
{
    private ItemFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ItemFactory();
    }

    public function testCreateFruit(): void
    {
        $name = 'Apple';
        $weight = 150;
        $type = 'fruit';
        $unit = 'g';

        $result = $this->factory->createItem($name, $weight, $type, $unit);

        $this->assertInstanceOf(Fruit::class, $result);
    }

    public function testCreateVegetable(): void
    {
        $name = 'Carrot';
        $weight = 200;
        $type = 'vegetable';
        $unit = 'g';

        $result = $this->factory->createItem($name, $weight, $type, $unit);

        $this->assertInstanceOf(Vegetable::class, $result);
    }

    public function testInvalidTypeThrowsException(): void
    {
        $this->expectException(\TypeError::class);

        $this->factory->createItem('Invalid', 100, 'invalid_type', 'g');
    }
}