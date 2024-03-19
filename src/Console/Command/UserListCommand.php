<?php

namespace SonOfHarris\Meetup\Generators\Console\Command;

use SonOfHarris\Meetup\Generators\Data\UserDataSource;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'user:list',
    description: 'Returns a list of users in JSON format to emulate an API'
)]
class UserListCommand extends Command
{
    protected function configure(): void
    {
        $this->addOption('start', null, InputOption::VALUE_OPTIONAL, "Starting position", 0);
        $this->addOption('length', null, InputOption::VALUE_OPTIONAL, 'Maximum number of items', 100);
        $this->addOption('delay', null, InputOption::VALUE_OPTIONAL, 'Milli-seconds to delay response', 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $delay = (int) $input->getOption('delay');
        if ($delay > 0) {
            usleep($delay * 1000);
        }


        $source = new UserDataSource(
            __DIR__ . '/../../../data/users.txt'
        );
        
        $start = (int) $input->getOption('start');
        $length = (int) $input->getOption('length');
        $count = count($source);

        $output->write(
            json_encode(
                [
                    'total' => $count,
                    'start' => $start,
                    'next' => min($start + $length, $count),
                    'data' => iterator_to_array(
                        $source($start, $length)
                    ),
                ]
            )
        );

        return Command::SUCCESS;
    }
}
