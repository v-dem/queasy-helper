<?php

namespace queasy\helper;

class Strings
{
    public static function startsWith($string, $start)
    {
        return strpos($string, $start) === 0;
    }
}


