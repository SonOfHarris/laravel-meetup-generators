<?php

use SonOfHarris\Meetup\Generators\Data\UserApiClient;

$client = new UserApiClient();
$client->setDefaultLength(3);
$client->setDelay(0);
$client->setDebug(true);

echo "INFO: Batched generator (foreach yield)" . PHP_EOL;
$pos = 1;
foreach ($client->listManyIndexed($pos, 11) as $key => $user) {
    echo "{$pos}. {$key} => {$user->first_name} {$user->last_name}" . PHP_EOL;
    $pos++;
}

echo PHP_EOL;
echo "INFO: Batched generator (yield from)" . PHP_EOL;
$pos = 1;
foreach ($client->listMany($pos, 11) as $key => $user) {
    echo "{$pos}. {$key} => {$user->first_name} {$user->last_name}" . PHP_EOL;
    $pos++;
}

echo PHP_EOL;
echo "INFO: Batched array" . PHP_EOL;
$pos = 1;
foreach ($client->listManyArray($pos, 11) as $key => $user) {
    echo "{$pos}. {$key} => {$user->first_name} {$user->last_name}" . PHP_EOL;
    $pos++;
}

// INFO: Batched generator (foreach yield)
// DEBUG: [listManyIndexed] Start
// DEBUG: [api] user:list --start=1 --length=3 --delay=0
// 1. 0 => Caden Sawayn
// 2. 1 => Providenci Jaskolski
// 3. 2 => Rollin Zulauf
// DEBUG: [api] user:list --start=4 --length=3 --delay=0
// 4. 3 => Mathias Howe
// 5. 4 => Tracey Hammes
// 6. 5 => Darien Krajcik
// DEBUG: [api] user:list --start=7 --length=3 --delay=0
// 7. 6 => Damon Willms
// 8. 7 => Collin Morar
// 9. 8 => Wallace Pacocha
// DEBUG: [api] user:list --start=10 --length=2 --delay=0
// 10. 9 => Jaiden Jast
// 11. 10 => Leilani Kris
// DEBUG: [listManyIndexed] End

// INFO: Batched generator (yield from)
// DEBUG: [listMany] Start
// DEBUG: [api] user:list --start=1 --length=3 --delay=0
// 1. 0 => Caden Sawayn
// 2. 1 => Providenci Jaskolski
// 3. 2 => Rollin Zulauf
// DEBUG: [api] user:list --start=4 --length=3 --delay=0
// 4. 0 => Mathias Howe
// 5. 1 => Tracey Hammes
// 6. 2 => Darien Krajcik
// DEBUG: [api] user:list --start=7 --length=3 --delay=0
// 7. 0 => Damon Willms
// 8. 1 => Collin Morar
// 9. 2 => Wallace Pacocha
// DEBUG: [api] user:list --start=10 --length=2 --delay=0
// 10. 0 => Jaiden Jast
// 11. 1 => Leilani Kris
// DEBUG: [listMany] End

// INFO: Batched array
// DEBUG: [listManyArray] Start
// DEBUG: [api] user:list --start=1 --length=3 --delay=0
// DEBUG: [api] user:list --start=4 --length=3 --delay=0
// DEBUG: [api] user:list --start=7 --length=3 --delay=0
// DEBUG: [api] user:list --start=10 --length=2 --delay=0
// DEBUG: [listManyArray] End
// 1. 0 => Caden Sawayn
// 2. 1 => Providenci Jaskolski
// 3. 2 => Rollin Zulauf
// 4. 3 => Mathias Howe
// 5. 4 => Tracey Hammes
// 6. 5 => Darien Krajcik
// 7. 6 => Damon Willms
// 8. 7 => Collin Morar
// 9. 8 => Wallace Pacocha
// 10. 9 => Jaiden Jast
// 11. 10 => Leilani Kris