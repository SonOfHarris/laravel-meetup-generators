<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

use Generator;
use SonOfHarris\Meetup\Generators\Model\User;

class MapImportBench
{
    use FromUserData;

    private function yieldTweak(iterable $source): Generator
    {
        $year = date('Y');
        foreach ($source as $row) {
            $row['age'] = $row['yob'] - $year;
            yield $row;
        }
    }

    private function yieldUser(iterable $source): Generator
    {
        foreach ($source as $row) {
            yield User::fromData($row);
        }
    }

    private function mapTweak(array $source): array
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

    private function mapUser(array $source): array
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
    public function benchGeneratorChain(): void
    {        
        $users = $this->yieldUser(
            $this->yieldTweak(
                $this->basic()->asGenerator()
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
        $users = $this->basic()->asGenerator();
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
                $this->basic()->asArray()
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
        $users = $this->basic()->asArray();
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
                $this->basic()->asArray()
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
                    $this->basic()->asGenerator()
                )
            )
        );

        $count = 0;
        foreach ($users as $user) {
            $count++;
        }
    }
}
