<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

use SonOfHarris\Meetup\Generators\Data\BasicImport;

trait FromUserData
{
    protected function filePath()
    {
        return __DIR__ . '/../../data/users.txt';
    }

    private function basic()
    {
        return new BasicImport($this->filePath());
    }
}
