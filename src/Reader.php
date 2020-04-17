<?php

namespace Reader;

use Reader\Storage\Storage;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class Reader
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function fileExist(string $path, OutputInterface $output): void
    {
        if (!file_exists($path)) {
            $output->writeln('<error>This file does not exist!</error>');
            exit(3);
        }
    }

    public function isReadable(string $path, OutputInterface $output): void
    {
        if (!is_readable($path)) {
            $output->writeln('<error>Can not read this file!</error>');
            exit(7);
        }
    }

    public function getDigitStatistic(string $path, OutputInterface $output): void
    {
        $this->readFile($path);

        $table = new Table($output);
        $table->setHeaders(['Digit', 'Count']);
        $table->setRows($this->storage->getCounters('desc'));
        $table->setStyle('box');
        $table->render();

        exit(0);
    }

    private function readFile($path): void
    {
        $handle = fopen($path, 'rb');

        while (!feof($handle)) {
            $row = fgets($handle);

            preg_match_all('/(?<digits>\d+)/', $row, $matches);

            if ($matches['digits'] === []) {
                continue;
            }

            foreach($matches['digits'] as $digit) {
                if ($this->storage->issetDigit($digit)) {
                    $this->storage->increaseCounter($digit);
                } else {
                    $this->storage->addCounter($digit);
                }
            }
        }

        fclose($handle);
    }
}
