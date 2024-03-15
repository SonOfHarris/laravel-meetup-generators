<?php

namespace SonOfHarris\Meetup\Generators\Tests\Data;

use SonOfHarris\Meetup\Generators\Data\BasicImport;

class BasicImportBench
{
    private $file = __DIR__ . '/../../data/users.txt';

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchArray()
    {
        $import = new BasicImport($this->file);
        $count = 0;
        foreach ($import->asArray() as $row) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGenerator()
    {
        $import = new BasicImport($this->file);
        $count = 0;
        foreach ($import->asGenerator() as $row) {
            $count++;
        }
    }

    /**
     * @Revs(10)
     * @Iterations(3)
     */
    public function benchGeneratorArray()
    {
        $import = new BasicImport($this->file);
        $data = iterator_to_array($import->asGenerator());
        $count = count($data);
    }
}
