<?php

namespace SonOfHarris\Meetup\Generators\Console;

use SonOfHarris\Meetup\Generators\Console\Command\RunExampleCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    public function __construct()
    {
        parent::__construct('PHP Generators', 'current');

        $this->add(new RunExampleCommand());
    }
}