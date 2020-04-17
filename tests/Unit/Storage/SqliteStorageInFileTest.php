<?php

namespace Unit\Storage;

use PHPUnit\Framework\TestCase;
use Reader\Storage\SqliteStorage;

class SqliteStorageInFileTest extends TestCase
{
    private SqliteStorage $storage;
    private string $storageFile = __DIR__ . '/storage.db';

    public function setUp(): void
    {
        $this->storage = new SqliteStorage($this->storageFile);
    }

    public function tearDown(): void
    {
        unlink($this->storageFile);
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
        $this->assertEquals([['digit' => $expected, 'count' => 2]], $this->storage->getCounters());
    }

    public function testAddCounter(): void
    {
        $this->storage->addCounter($expected = 42);
        $this->assertEquals([['digit' => $expected, 'count' => 1]], $this->storage->getCounters());
    }
}
