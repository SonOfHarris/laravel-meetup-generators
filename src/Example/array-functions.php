<?php

use SonOfHarris\Meetup\Generators\Data\UserDataSource;

$source = new UserDataSource(__DIR__ . '/../../data/users.txt');

$users = array_filter(
    // $source(0, 1000),
    iterator_to_array($source(0, 1000)),
    function ($user) {
        return substr($user['last_name'], 0, 1) == 'A';
    }
);
echo "Found " . count($users) . " users" . PHP_EOL;
