<?php

use SonOfHarris\Meetup\Generators\Data\UserDataSource;

$source = new UserDataSource(__DIR__ . '/../../data/users.txt');
$source->setDebug(true);

echo "INFO: Looping until end" . PHP_EOL;
$count = 0;
foreach ($source(0, 10) as $row) {
    echo "{$count}. {$row['first_name']} {$row['last_name']}" . PHP_EOL;
    $count++;
}

echo PHP_EOL;
echo "INFO: Looping half way" . PHP_EOL;
$count = 0;
foreach ($source(0, 10) as $row) {
    echo "{$count}. {$row['first_name']} {$row['last_name']}" . PHP_EOL;
    $count++;
    if ($count >= 5) {
        break;
    }
}
