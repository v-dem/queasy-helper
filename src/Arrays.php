<?php

namespace queasy\helper;

class Arrays
{
    public static function flatten(array $array)
    {
        $return = array();

        array_walk_recursive($array, function($value, $key) use (&$return) {
            $return[$key] = $value;
        });

        return $return;
    }
}

