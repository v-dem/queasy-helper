<?php

namespace queasy\helper;

class System
{
    public static function callUserFuncArray($handler, array $args = array())
    {
        switch (count($args)) {
            case 0:
                return $handler();

            case 1:
                return $handler($args[0]);

            case 2:
                return $handler($args[0], $args[1]);
        }

        return call_user_func_array($handler, $args);
    }
}

