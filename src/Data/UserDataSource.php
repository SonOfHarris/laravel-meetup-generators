<?php

namespace SonOfHarris\Meetup\Generators\Data;

class UserDataSource
{
    public function __construct(private $file)
    {
    }

    public function page(int $start, int $count = null)
    {
        $header = null;
        $pos = 0;
        $end = $start ? ($start + $count) : null;
        $fp = fopen($this->file, 'r');
        while (false !== ($line = fgetcsv($fp, null, "\t"))) {
            if ($header === null) {
                $header = array_flip($line);
                continue;
            }

            if ($pos >= $start) {
                $row = [];
                foreach ($header as $pos => $name) {
                    $row[$name] = @$line[$pos];
                }
                yield $row;
            }
            
            $pos++;
            if ($end !== null && $pos >= $end) {
                break;
            }
        }
        fclose($fp);
    }

    public function all()
    {
        yield from $this->page(0);
    }
}
