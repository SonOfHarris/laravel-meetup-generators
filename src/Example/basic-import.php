<?php

use SonOfHarris\Meetup\Generators\Data\BasicImport;

$source = new BasicImport(__DIR__ . '/../../data/users.txt');
foreach ($source->asGenerator() as $row) {
    echo var_export($row, true) . PHP_EOL;
    break;
}
