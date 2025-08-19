<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\WeightValueObject;
use PHPUnit\Framework\TestCase;

class WeightValueObjectTest extends TestCase
{
    public function testStoresValueInGramsWhenGivenGrams(): void
    {
        $weight = new WeightValueObject(150, 'g');
        $this->assertSame(150, $weight->value());
        $this->assertSame(0.15, $weight->toKg());
    }

    public function testConvertsKilogramsToGramsOnConstruction(): void
    {
        $weight = new WeightValueObject(2, 'kg');
        $this->assertSame(2000, $weight->value());
        $this->assertSame(2.0, $weight->toKg());
    }

    public function testDefaultsToGramsWhenUnitNotProvided(): void
    {
        $weight = new WeightValueObject(500);
        $this->assertSame(500, $weight->value());
        $this->assertSame(0.5, $weight->toKg());
    }

    public function testThrowsOnInvalidUnit(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid weight unit');
        new WeightValueObject(100, 'lb');
    }
} 