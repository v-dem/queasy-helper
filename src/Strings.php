<?php

namespace queasy\helper;

class Strings
{
    public static function startsWith($string, $start)
    {
        return strpos($string, $start) === 0;
    }

    public static function endsWith($string, $end)
    {
        return strpos($string, $end) == strlen($string) - strlen($end);
    }
}

