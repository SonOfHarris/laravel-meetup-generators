<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

use SonOfHarris\Meetup\Generators\Data\UserApiClient;

class UserApiBench
{
    /**
     * @Revs(5)
     * @Iterations(3)
     */
    public function benchSinglePageGenerator()
    {
        $client = new UserApiClient();
        $client->setDefaultLength(100);

        $count = 0;
        foreach ($client->list()->asGenerator() as $user) {
            $count++;
        }
    }

    /**
     * @Revs(5)
     * @Iterations(3)
     */
    public function benchSinglePageArray()
    {
        $client = new UserApiClient();
        $client->setDefaultLength(100);

        $count = 0;
        foreach ($client->list()->asArray() as $user) {
            $count++;
        }
    }

    public function benchPaginatedGenerator()
    {
        $client = new UserApiClient();
        $client->setDefaultLength(100);
        $client->setDelay(100);

        $count = 0;
        foreach ($client->listMany(0, 1000) as $user) {
            usleep(500);
            $count++;
        }
    }

    public function benchPaginatedArray()
    {
        $client = new UserApiClient();
        $client->setDefaultLength(100);
        $client->setDelay(100);

        $count = 0;
        foreach ($client->listManyArray(0, 1000) as $user) {
            usleep(500);
            $count++;
        }
    }

    public function benchPaginatedAsyncGenerator()
    {
        $client = new UserApiClient();
        $client->setDefaultLength(100);
        $client->setDelay(100);

        $count = 0;
        foreach ($client->listManyAsync(0, 1000) as $user) {
            usleep(500);
            $count++;
        }
    }

    public function benchPaginatedAsyncArray()
    {
        $client = new UserApiClient();
        $client->setDefaultLength(100);
        $client->setDelay(100);

        $count = 0;
        foreach ($client->listManyAsyncArray(0, 1000) as $user) {
            usleep(500);
            $count++;
        }
    }
}
