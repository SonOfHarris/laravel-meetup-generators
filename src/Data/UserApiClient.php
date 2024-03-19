<?php

namespace SonOfHarris\Meetup\Generators\Data;

use Generator;
use Symfony\Component\Process\Process;

class UserApiClient
{
    private int $delay = 0;

    private int $defaultLength = 10;

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

    public function toCollection(Process $process): UserCollection
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
        return $this->toCollection($process);
    }

    public function listAsync(int $start = 0, int $length = null): Process
    {
        if ($length == null) {
            $length = $this->defaultLength;
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
        $pos = $start;
        do {
            $result = $this->list($pos, $this->defaultLength);
            if ($end === null) {
                $end = $result->getTotal();
            }
            foreach ($result->asGenerator() as $user) {
                yield $user;
                $pos++;
                if ($pos >= $end) {
                    break;
                }
            }
        } while ($pos < $end);
    }

    public function listManyArray(int $start = 0, int $end = null): array
    {
        $users = [];
        $pos = $start;
        do {
            $result = $this->list($pos, $this->defaultLength);
            if ($end === null) {
                $end = $result->getTotal();
            }
            foreach ($result->asArray() as $user) {
                $users[] = $user;
                $pos++;
                if ($pos >= $end) {
                    break;
                }
            }
        } while ($pos < $end);
        return $users;
    }

    public function listManyAsync(int $start = 0, int $end = null): Generator
    {
        $pos = $start;
        $process = $this->listAsync($pos, $this->defaultLength);
        do {
            $process->wait();
            $result = $this->toCollection($process);
            if ($end === null) {
                $end = $result->getTotal();
            }

            if (($pos + count($result)) < $end) {
                $process = $this->listAsync($pos + count($result), $this->defaultLength);
            }

            foreach ($result->asGenerator() as $user) {
                yield $user;
                $pos++;
                if ($pos >= $end) {
                    break;
                }
            }
        } while ($pos < $end);
    }

    public function listManyAsyncArray(int $start = 0, int $end = null): array
    {
        $users = [];

        $pos = $start;
        $process = $this->listAsync($pos, $this->defaultLength);
        do {
            $process->wait();
            $result = $this->toCollection($process);
            if ($end === null) {
                $end = $result->getTotal();
            }

            if (($pos + count($result)) < $end) {
                $process = $this->listAsync($pos + count($result), $this->defaultLength);
            }

            foreach ($result->asGenerator() as $user) {
                $users[] = $user;
                $pos++;
                if ($pos >= $end) {
                    break;
                }
            }
        } while ($pos < $end);

        return $users;
    }
}
