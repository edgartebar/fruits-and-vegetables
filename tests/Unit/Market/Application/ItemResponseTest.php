<?php

declare(strict_types=1);

namespace App\Tests\Unit\Market\Application;

use App\Market\Application\ItemResponse;
use PHPUnit\Framework\TestCase;

class ItemResponseTest extends TestCase
{
    public function testItemResponse(): void
    {
        $id = '123';
        $name = 'Tomato';
        $weight = 150.0;
        $type = 'fruit';
        $units = 'g';

        $itemResponse = new ItemResponse($id, $name, $weight, $type, $units);

        $this->assertEquals($id, $itemResponse->id());
        $this->assertEquals($name, $itemResponse->getName());
        $this->assertEquals($weight, $itemResponse->getWeight());
        $this->assertEquals($type, $itemResponse->getType());
        $this->assertEquals($units, $itemResponse->getUnits());

        $expectedArray = [
            'id' => $id,
            'name' => $name,
            'weight' => $weight,
            'type' => $type,
            'units' => $units,
        ];

        $this->assertEquals($expectedArray, $itemResponse->toArray());
    }
}