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

        $generateData = function () {
            $faker = Factory::create();
            while(true) {
                yield [
                    'first_name' => $faker->firstName(),
                    'last_name' => $faker->lastName(),
                    'username' => $faker->userName(),
                    'email' => $faker->email(),
                    'yob' => $faker->numberBetween(1960, 2010),
                ];
            }
        };

        $generateFrom = function ($generator, $length) {
            $count = 0;
            foreach ($generator() as $data) {
                yield $data;
                if (++$count >= $length) {
                    break;
                }
            }
        };

        $header = true;
        foreach ($generateFrom($generateData, $length) as $data) {
            if ($header) {
                fputcsv(STDOUT, array_keys($data), "\t");
                $header = false;
            }
            fputcsv(STDOUT, $data, "\t");
        }

        return Command::SUCCESS;
    }
}
