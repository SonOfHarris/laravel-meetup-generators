<?php

namespace SonOfHarris\Meetup\Generators\Data;

use Countable;
use Generator;
use SonOfHarris\Meetup\Generators\Model\User;

class UserCollection implements Countable
{
    public function __construct(private array $result)
    {
    }

    public function count(): int
    {
        return count($this->result['data']);
    }

    public function getTotal(): int
    {
        return $this->result['total'];
    }

    public function nextStart(): int
    {
        return $this->result['next'];
    }

    /**
     * @return Generator|User[]
     */
    public function asGenerator(): Generator
    {
        foreach ($this->result['data'] as $row) {
            yield User::fromData($row);
        }
    }

    /**
     * @return User[]
     */
    public function asArray(): array
    {
        return array_map(
            function ($row) {
                return User::fromData($row);
            },
            $this->result['data']
        );
    }
}
