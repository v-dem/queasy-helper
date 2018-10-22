<?php

namespace queasy\helper;

class Arrays
{
    public static function flatten(array $array)
    {
        if (!is_array($array)) {
            $array = func_get_args();
        }

        $result = array();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }

        return $result;
    }
}

