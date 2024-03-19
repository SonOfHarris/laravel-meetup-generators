<?php

namespace SonOfHarris\Meetup\Generators\Console;

use SonOfHarris\Meetup\Generators\Console\Command\BenchmarkCommand;
use SonOfHarris\Meetup\Generators\Console\Command\GenerateDataCommand;
use SonOfHarris\Meetup\Generators\Console\Command\RunExampleCommand;
use SonOfHarris\Meetup\Generators\Console\Command\UserListCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    public function __construct()
    {
        parent::__construct('PHP Generators', 'current');

        $this->add(new BenchmarkCommand());
        $this->add(new GenerateDataCommand());
        $this->add(new RunExampleCommand());
        $this->add(new UserListCommand());
    }
}
