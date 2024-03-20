<?php

namespace SonOfHarris\Meetup\Generators\Data;

use Generator;
use Symfony\Component\Process\Process;

class UserApiClient
{
    private int $delay = 0;

    private int $defaultLength = 10;

    private bool $debug = false;

    public function __construct()
    {
    }

    public function setDelay(int $delay): void
    {
        $this->delay = $delay;
    }

    public function setDefaultLength(int $length): void
    {
        $this->defaultLength = $length;
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    public function getCollection(Process $process): UserCollection
    {
        $output = $process->getOutput();
        return new UserCollection(
            json_decode(
                $process->getOutput(),
                true
            )
        );
    }

    public function list(int $start = 0, int $length = null): UserCollection
    {
        $process = $this->listAsync($start, $length);
        $process->wait();
        return $this->getCollection($process);
    }

    public function listAsync(int $start = 0, int $length = null): Process
    {
        if ($length == null) {
            $length = $this->defaultLength;
        }

        if ($this->debug) {
            echo "DEBUG: [api] user:list --start={$start} --length={$length} --delay={$this->delay}" . PHP_EOL;
        }

        $process = new Process(
            [
                'php',
                'gen',
                'user:list',
                "--start={$start}",
                "--length={$length}",
                "--delay={$this->delay}"
            ]
        );
        $process->start();
        return $process;
    }

    public function listMany(int $start = 0, int $end = null): Generator
    {
        if ($this->debug) {
            echo "DEBUG: [listMany] Start" . PHP_EOL;
        }

        $batchStart = $start;
        do {
            $batchEnd = $batchStart + $this->defaultLength - 1;
            if ($end !== null && $batchEnd > $end) {
                $batchEnd = $end;
            }

            $result = $this->list($batchStart, $batchEnd - $batchStart + 1);
            if ($end === null) {
                $end = $result->getTotal();
            }

            yield from $result->asGenerator();

            $batchStart += count($result);
        } while ($batchStart < $end);

        if ($this->debug) {
            echo "DEBUG: [listMany] End" . PHP_EOL;
        }
    }

    public function listManyArray(int $start = 0, int $end = null): array
    {
        if ($this->debug) {
            echo "DEBUG: [listManyArray] Start" . PHP_EOL;
        }

        $users = [];
        $batchStart = $start;
        do {
            $batchEnd = $batchStart + $this->defaultLength - 1;
            if ($end !== null && $batchEnd > $end) {
                $batchEnd = $end;
            }

            $result = $this->list($batchStart, $batchEnd - $batchStart + 1);
            if ($end === null) {
                $end = $result->getTotal();
            }

            foreach ($result->asArray() as $user) {
                $users[] = $user;
            }

            $batchStart += count($result);
        } while ($batchStart < $end);

        if ($this->debug) {
            echo "DEBUG: [listManyArray] End" . PHP_EOL;
        }

        return $users;
    }

    public function listManyAsync(int $start = 0, int $end = null): Generator
    {
        $batchStart = $start;
        $batchEnd = $batchStart + $this->defaultLength - 1;
        if ($end !== null && $batchEnd > $end) {
            $batchEnd = $end;
        }

        $process = $this->listAsync($batchStart, $batchEnd - $batchStart + 1);
        do {
            $process->wait();
            $result = $this->getCollection($process);
            if ($end === null) {
                $end = $result->getTotal();
            }

            $batchStart += count($result);
            $batchEnd = $batchStart + $this->defaultLength - 1;
            if ($end !== null && $batchEnd > $end) {
                $batchEnd = $end;
            }
    
            if ($batchStart < $end) {
                $process = $this->listAsync($batchStart, $batchEnd - $batchStart + 1);
            }

            yield from $result->asGenerator();
        } while ($batchStart < $end);
    }

    public function listManyAsyncArray(int $start = 0, int $end = null): array
    {
        $users = [];

        $batchStart = $start;
        $batchEnd = $batchStart + $this->defaultLength - 1;
        if ($end !== null && $batchEnd > $end) {
            $batchEnd = $end;
        }

        $process = $this->listAsync($batchStart, $batchEnd - $batchStart + 1);
        do {
            $process->wait();
            $result = $this->getCollection($process);
            if ($end === null) {
                $end = $result->getTotal();
            }

            $batchStart += count($result);
            $batchEnd = $batchStart + $this->defaultLength - 1;
            if ($end !== null && $batchEnd > $end) {
                $batchEnd = $end;
            }
    
            if ($batchStart < $end) {
                $process = $this->listAsync($batchStart, $batchEnd - $batchStart + 1);
            }

            foreach ($result->asArray() as $user) {
                $users[] = $user;
            }
        } while ($batchStart < $end);

        return $users;
    }
}
