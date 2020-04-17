<?php

namespace Reader\Storage;

interface Storage
{
    public function issetDigit(int $digit): bool;
    public function increaseCounter(int $for): void;
    public function addCounter(int $for): void;
    public function getCounters(string $sort = null): array;
}
