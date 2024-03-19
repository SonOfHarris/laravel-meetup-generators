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

// INFO: Looping until end
// DEBUG: Opened resource(70) of type (stream)
// 0. Halle Bosco
// 1. Caden Sawayn
// ...
// 9. Wallace Pacocha
// DEBUG: Closing resource(70) of type (stream)

// INFO: Looping half way
// DEBUG: Opened resource(71) of type (stream)
// 0. Halle Bosco
// 1. Caden Sawayn
// ...
// 4. Mathias Howe
// DEBUG: Closing resource(71) of type (stream)

// Without try { ... } finally { ... }

// INFO: Looping half way
// DEBUG: Opened resource(71) of type (stream)
// 0. Halle Bosco
// 1. Caden Sawayn
// ...
// 4. Mathias Howe

// The resource is not actively closed
