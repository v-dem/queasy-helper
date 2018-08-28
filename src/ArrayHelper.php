<?php

namespace queasy\helper;

class ArrayHelper
{
    public static function flatten(array $array)
    {
        // test

        $return = array();

        array_walk_recursive($array, function($value, $key) use (&$return) {
            $return[$key] = $value;
        });

        return $return;
    }
}

