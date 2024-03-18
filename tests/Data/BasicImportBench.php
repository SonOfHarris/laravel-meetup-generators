<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

class BasicImportBench
{
    use FromUserData;

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchArray()
    {
        $source = $this->basic();
        $count = 0;
        foreach ($source->asArray() as $row) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGenerator()
    {
        $source = $this->basic();
        $count = 0;
        foreach ($source->asGenerator() as $row) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGeneratorToArray()
    {
        $source = $this->basic();
        $data = iterator_to_array($source->asGenerator());
        $count = count($data);
    }
}
