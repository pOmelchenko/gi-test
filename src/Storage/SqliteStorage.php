<?php

namespace Reader\Storage;

use PDO;

class SqliteStorage implements Storage
{
    private string $path;
    private PDO $storage;

    public function __construct(string $path = null)
    {
        $this->path = $path ?? ':memory:';

        $this->createStorage();
    }

    private function createStorage(): void
    {
        $this->storage = new PDO("sqlite:{$this->path}");
        $this->createTable();
    }

    private function createTable(): void
    {
        $sql = <<<SQL
        create table if not exists digits
        (
            digit INTEGER not null,
            count INTEGER default 1 not null
        );
        
        create unique index digits_digit_uindex
            on digits (digit);
        SQL;

        $this->storage->exec($sql);
    }

    public function issetDigit(int $digit): bool
    {
        $query = $this->storage->query('select digit from digits where digit = :digit;');
        $query->bindParam(':digit', $digit);
        $query->execute();

        return [] !== $query->fetchAll();
    }

    public function increaseCounter(int $for): void
    {
        $query = $this->storage->query('update digits set count = count + 1 where digit = :digit;');
        $query->bindParam(':digit', $for);
        $query->execute();
    }

    public function addCounter(int $for): void
    {
        $query = $this->storage->prepare('insert into digits (digit) values (:digit);');
        $query->bindParam(':digit', $for);
        $query->execute();
    }

    public function getCounters(string $sort = null): array
    {
        switch (strtolower($sort)) {
            case 'asc':
                $sql = 'select * from digits order by count;';
                break;
            case 'desc':
                $sql = 'select * from digits order by count desc;';
                break;
            case null:
                $sql = 'select digit, count from digits;';
                break;
            default:
                throw new \InvalidArgumentException('Possible only asc, desc or null value');
        }

        $query = $this->storage->query($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_NAMED);
    }

    public function __destruct()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }
}
