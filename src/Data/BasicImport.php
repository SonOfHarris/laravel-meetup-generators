<?php

namespace SonOfHarris\Meetup\Generators\Data;

class BasicImport
{
    public function __construct(private $file)
    {
    }

    public function asArray()
    {
        $data = [];
        $header = null;
        $fp = fopen($this->file, 'r');
        while (false !== ($line = fgetcsv($fp, null, "\t"))) {
            if ($header === null) {
                $header = array_flip($line);
                continue;
            }
            $row = [];
            foreach ($header as $pos => $name) {
                $row[$name] = @$line[$pos];
            }
            $data[] = $row;
        }
        fclose($fp);
        return $data;
    }

    public function asGenerator()
    {
        $header = null;
        $fp = fopen($this->file, 'r');
        while (false !== ($line = fgetcsv($fp, null, "\t"))) {
            if ($header === null) {
                $header = array_flip($line);
                continue;
            }
            $row = [];
            foreach ($header as $pos => $name) {
                $row[$name] = @$line[$pos];
            }
            yield $row;
        }
        fclose($fp);
    }
}
