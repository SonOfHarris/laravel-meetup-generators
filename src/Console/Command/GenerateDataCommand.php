<?php

namespace SonOfHarris\Meetup\Generators\Console\Command;

use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate-data',
    description: 'Output user data in TSV format'
)]
class GenerateDataCommand extends Command
{
    protected function configure(): void
    {
        $this->addOption('length', null, InputOption::VALUE_OPTIONAL, 'Number of records', 1000);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $length = $input->getOption('length');

        $header = [
            'first_name',
            'last_name',
            'username',
            'email',
            'yob',
        ];

        $faker = Factory::create();

        $output->writeln(implode("\t", $header));

        $generateData = function ($count) use ($faker) {
            for ($i = 0; $i < $count; $i++) {
                yield [
                    'first_name' => $faker->firstName(),
                    'last_name' => $faker->lastName(),
                    'username' => $faker->userName(),
                    'email' => $faker->email(),
                    'yob' => $faker->numberBetween(1960, 2010),
                ];
            }
        };

        foreach ($generateData($length) as $data) {
            $output->writeln(implode("\t", $data));
        }

        return Command::SUCCESS;
    }
}
