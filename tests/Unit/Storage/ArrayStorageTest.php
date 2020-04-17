<?php

namespace Unit\Storage;

use PHPUnit\Framework\TestCase;
use Reader\Storage\ArrayStorage;

class ArrayStorageTest extends TestCase
{
    private ArrayStorage $storage;

    public function setUp(): void
    {
        $this->storage = new ArrayStorage();
    }

    public function testIssetDigit(): void
    {
        $this->assertFalse($this->storage->issetDigit(PHP_INT_MAX));
    }

    public function testIncreaseCounter(): void
    {
        $this->storage->addCounter($expected = 42);
        $this->assertTrue($this->storage->issetDigit($expected));
        $this->storage->increaseCounter($expected);
        $this->assertEquals([$expected => ['digit' => $expected, 'count' => 2]], $this->storage->getCounters());
    }

    public function testAddCounter(): void
    {
        $this->storage->addCounter($expected = 42);
        $this->assertEquals([$expected => ['digit' => $expected, 'count' => 1]], $this->storage->getCounters());
    }
}
