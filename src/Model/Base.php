<?php

namespace SonOfHarris\Meetup\Generators\Model;

abstract class Base
{
    /**
     * Creates a new instance with the default values.
     * 
     * @var array
     * 
     * @return static
     */
    public static function fromData(array $array): static
    {
        $obj = new static();
        foreach ($array as $k => $v) {
            $obj->{$k} = $v;
        }
        return $obj;
    }
}
