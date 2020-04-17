<?php

namespace Reader\Commands;

use Reader\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CountDigit extends Command
{
    protected static $defaultName;

    private string $desctiprion;
    private Reader $reader;

    public function __construct(string $name, string $desctiprion, Reader $reader)
    {
        self::$defaultName = $name;
        $this->desctiprion = $desctiprion;

        $this->reader = $reader;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription($this->desctiprion);
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to file for reading');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $path = $input->getArgument('path');

        $this->reader->fileExist($path, $output);
        $this->reader->isReadable($path, $output);
        $this->reader->getDigitStatistic($path, $output);
    }
}
