<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

class TimeToFirstBench
{
    use FromUserData;

    /**
     * @Revs(10)
     * @Iterations(5)
     * @OutputTimeUnit("milliseconds")
     */
    public function benchGenerator()
    {
        foreach ($this->basic()->asGenerator() as $user) {
            break;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(5)
     * @OutputTimeUnit("milliseconds")
     */
    public function benchArray()
    {
        foreach ($this->basic()->asArray() as $user) {
            break;
        }
    }
}
