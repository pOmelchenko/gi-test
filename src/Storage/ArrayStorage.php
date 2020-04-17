<?php

namespace Reader\Storage;

class ArrayStorage implements Storage
{
    private array $storage = [];

    public function issetDigit($digit): bool
    {
        return isset($this->storage[$digit]);
    }

    public function addCounter(int $for): void
    {
        $this->storage[$for] = ['digit' => $for, 'count' => 1];
    }

    public function increaseCounter(int $for): void
    {
        $this->storage[$for]['count']++;
    }

    public function getCounters(string $sort = null): array
    {
        switch (strtolower($sort)) {
            case 'asc':
                usort($this->storage, [static::class, 'asc']);
                break;
            case 'desc':
                usort($this->storage, [static::class, 'desc']);
                break;
            case null:
                break;
            default:
                throw new \InvalidArgumentException('Possible only asc, desc or null value');
        }

        return $this->storage;
    }

    private function asc(array $a, array $b): int
    {
        return $a['count'] <=> $b['count'];
    }

    private function desc(array $a, array $b): int
    {
        return $b['count'] <=> $a['count'];
    }
}
