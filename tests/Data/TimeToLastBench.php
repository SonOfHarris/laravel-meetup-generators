<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

class TimeToLastBench
{
    use FromUserData;

    /**
     * @Revs(10)
     * @Iterations(5)
     * @OutputTimeUnit("milliseconds")
     */
    public function benchGenerator()
    {
        $count = 0;
        foreach ($this->basic()->asGenerator() as $user) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(5)
     * @OutputTimeUnit("milliseconds")
     */
    public function benchArray()
    {
        $count = 0;
        foreach ($this->basic()->asArray() as $user) {
            $count++;
        }
    }
}
