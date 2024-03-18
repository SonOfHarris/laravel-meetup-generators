<?php

namespace SonOfHarris\Meetup\Generators\Data;

use InvalidArgumentException;

class BasicImport
{
    public function __construct(private $file)
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException("File does not exist: {$file}");
        }
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
            foreach ($header as $name => $pos) {
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
            foreach ($header as $name => $pos) {
                $row[$name] = @$line[$pos];
            }
            yield $row;
        }
        fclose($fp);
    }
}
