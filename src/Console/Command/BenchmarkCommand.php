<?php

namespace SonOfHarris\Meetup\Generators\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'bench',
    description: 'Runs a benchmark test'
)]
class BenchmarkCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the example file (excluding .php)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $file = "tests/{$name}Bench.php";
        $filePath = __DIR__ . "/../../../{$file}";
        if (!file_exists($filePath)) {
            $output->writeln("ERROR: Unable to find bench: {$file}");
            return Command::FAILURE;
        }

        $exitCode = null;
        passthru(
            'vendor/bin/phpbench ' .
            'run ' .
            escapeshellarg($file) . ' ' .
            '--report=aggregate',
            $exitCode
        );

        return $exitCode;
    }
}
