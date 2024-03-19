<?php

namespace SonOfHarris\Meetup\Generators\Data;

use Countable;
use Generator;
use InvalidArgumentException;

class UserDataSource implements Countable
{
    private bool $debug = false;

    public function __construct(private $file)
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException("Unable to find file: {$file}");
        }
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    public function count(): int
    {
        $count = -1;
        $fp = fopen($this->file, 'r');
        while (false !== ($line = fgetcsv($fp, null, "\t"))) {
            $count++;
        }
        return $count;
    }

    public function __invoke(int $start, int $length = null): Generator
    {
        $header = null;
        $count = 0;
        $end = $length > 0 ? ($start + $length) : null;

        $fp = fopen($this->file, 'r');
        if ($this->debug) {
            echo "DEBUG: Opened ";
            var_dump($fp);
        }

        try {
            while (false !== ($line = fgetcsv($fp, null, "\t"))) {
                if ($header === null) {
                    $header = array_flip($line);
                    continue;
                }

                if ($count >= $start) {
                    $row = [];
                    foreach ($header as $name => $pos) {
                        $row[$name] = @$line[$pos];
                    }
                    yield $row;
                }
                
                $count++;
                if ($end !== null && $count >= $end) {
                    break;
                }
            }
        } finally {
            if ($this->debug) {
                echo "DEBUG: Closing ";
                var_dump($fp);
            }
            fclose($fp);
        }
    }
}
