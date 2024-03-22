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
echo "INFO: Looping half way (with finally)" . PHP_EOL;
$count = 0;
foreach ($source(0, 10) as $row) {
    echo "{$count}. {$row['first_name']} {$row['last_name']}" . PHP_EOL;
    $count++;
    if ($count >= 5) {
        break;
    }
}

echo PHP_EOL;
echo "INFO: Looping half way (without finally)" . PHP_EOL;
$source->setLateClose(true);
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
// 2. Providenci Jaskolski
// 3. Rollin Zulauf
// 4. Mathias Howe
// 5. Tracey Hammes
// 6. Darien Krajcik
// 7. Damon Willms
// 8. Collin Morar
// 9. Wallace Pacocha
// DEBUG: Closing resource(70) of type (stream)

// INFO: Looping half way (with finally)
// DEBUG: Opened resource(71) of type (stream)
// 0. Halle Bosco
// 1. Caden Sawayn
// 2. Providenci Jaskolski
// 3. Rollin Zulauf
// 4. Mathias Howe
// DEBUG: Closing resource(71) of type (stream)

// INFO: Looping half way (without finally)
// DEBUG: Opened resource(72) of type (stream)
// 0. Halle Bosco
// 1. Caden Sawayn
// 2. Providenci Jaskolski
// 3. Rollin Zulauf
// 4. Mathias Howe
