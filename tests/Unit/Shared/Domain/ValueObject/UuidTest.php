<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testConstructsWithValidUuidAndReturnsValue(): void
    {
        $id = '550e8400-e29b-41d4-a716-446655440000';
        $uuid = new Uuid($id);
        $this->assertSame($id, $uuid->value());
        $this->assertSame($id, (string)$uuid);
    }

    public function testFromStringCreatesSameValue(): void
    {
        $id = '123e4567-e89b-12d3-a456-426614174000';
        $uuid = Uuid::fromString($id);
        $this->assertSame($id, $uuid->value());
    }

    public function testEqualsComparesUnderlyingValues(): void
    {
        $id = '123e4567-e89b-12d3-a456-426614174000';
        $a = new Uuid($id);
        $b = new Uuid($id);
        $c = Uuid::random();

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
    }

    public function testThrowsOnInvalidUuid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Uuid('not-a-uuid');
    }
} 