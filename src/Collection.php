<?php

namespace queasy\helper;

class Collection
{
    private static $extensions = [];

    public static function extend($method, $callable)
    {
        self::$extensions[$method] = $callable;
    }

    private $array = [];

    private $arrays = null;

    public function __construct($array) // Array or Iterable
    {
        if (func_num_args() > 1) {
            $this->arrays = func_get_args(); // TODO: Implement multiple arrays passed to constructor (for use in array_map(), see PHP reference)
        } else {
            if (is_array($array)) {
                $this->array = $array;
            } else {
                foreach ($array as $key => $value) {
                    $this->array[$key] = $value;
                }
            }
        }
    }

    public function map(callable $callback)
    {
        return new Collection(array_map($callback, $this->array));
    }

    public function filter(callable $callback = null, $mode = 0)
    {
        if (null == $callback) {
            $callback = function($value) {
                return !empty($value);
            };
        }

        return new Collection(array_filter($this->array, $callback, $mode));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->array, $callback, $initial);
    }

    public function __call($method, array $args = array())
    {
        if (isset(self::$extensions[$method])) {
            // return System::callUserFuncArray(self::$extensions[$method], $args);
            return call_user_func_array(self::$extensions[$method], $args); // Exception!!!
        }

        throw new MethodNotFoundException(__CLASS__, $method);
    }
}


Collection::extend('toUpper', function($item) {
    return $this->map(function($item) {
        return strtoupper($item);
    });
});

echo (new Collection(['as', 10, 12, '1aa']))
    ->filter(function($item) {
        return is_string($item);
    })
    ->toUpper()
    ->reduce(function($carry, $item) {
        return empty($carry)
            ? $item
            : ', ' . $item;
    });

echo PHP_EOL;


