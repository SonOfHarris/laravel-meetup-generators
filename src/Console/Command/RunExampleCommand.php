<?php

namespace SonOfHarris\Meetup\Generators\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'run-example',
    description: 'Runs a file in the Example folder'
)]
class RunExampleCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the example file (excluding .php)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $filePath = __DIR__ . "/../../Example/{$name}.php";
        if (!file_exists($filePath)) {
            $output->writeln("ERROR: Unable to find example: {$name}");
            return Command::FAILURE;
        }

        require $filePath;
        echo PHP_EOL;

        return Command::SUCCESS;
    }
}
