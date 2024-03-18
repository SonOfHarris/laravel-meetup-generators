<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

use SonOfHarris\Meetup\Generators\Data\BasicImport;
use SonOfHarris\Meetup\Generators\Model\User;

class MapImportBench
{
    private $file = __DIR__ . '/../../data/users.txt';

    private function source()
    {
        return new BasicImport($this->file);
    }

    private function yieldTweak($source)
    {
        $year = date('Y');
        foreach ($source as $row) {
            $row['age'] = $row['yob'] - $year;
            yield $row;
        }
    }

    private function yieldUser($source)
    {
        foreach ($source as $row) {
            yield User::fromData($row);
        }
    }

    private function mapTweak($source)
    {
        $year = date('Y');
        return array_map(
            function ($row) use ($year) {
                $row['age'] = $row['yob'] - $year;
                return $row;
            },
            $source
        );
    }

    private function mapUser($source)
    {
        return array_map(
            function ($row) {
                return User::fromData($row);
            },
            $source
        );
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGeneratorChain()
    {        
        $users = $this->yieldUser(
            $this->yieldTweak(
                $this->source()->asGenerator()
            )
        );

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGeneratorSequential()
    {
        $users = $this->source()->asGenerator();
        $users = $this->yieldTweak($users);
        $users = $this->yieldUser($users);

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchArrayMapChain()
    {
        $users = $this->mapUser(
            $this->mapTweak(
                $this->source()->asArray()
            )
        );

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchArrayMapSequential()
    {
        $users = $this->source()->asArray();
        $users = $this->mapTweak($users);
        $users = $this->mapUser($users);

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }

        /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchArrayToGeneratorChain()
    {
        $users = $this->yieldUser(
            $this->yieldTweak(
                $this->source()->asArray()
            )
        );

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGeneratorToArrayMap()
    {
        $users = $this->mapUser(
            $this->mapTweak(
                iterator_to_array(
                    $this->source()->asGenerator()
                )
            )
        );

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }
}
