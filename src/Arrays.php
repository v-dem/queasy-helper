<?php

namespace queasy\helper;

use InvalidArgumentException;

use ArrayAccess;
use Iterator;

class Arrays
{
    /**
     * Convert a multi-dimensional array to single-dimensional.
     *
     * @param array Source multi-dimensional array
     *
     * @return array Single-dimensional array
     */
    public static function flatten(array $array)
    {
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

    /**
     * Create a key/value map by an array key or object field.
     *
     * @param string $field Field or key name
     * @param array $rows Array of arrays or objects
     *
     * @return array Array containing $field values as a keys and associated rows as a values
     */
    public static function map($field, array $rows)
    {
        $result = array();
        foreach ($rows as $row) {
            if (is_array($row)) {
                $result[$row[$field]] = $row;
            } elseif (is_object($row)) {
                $result[$row->$field] = $row;
            } else {
                throw new InvalidArgumentException('Unexpected value. Must be array or object.');
            }
        }

        return $result;
    }

    public static function merge()
    {
        $arrays = func_get_args();
        $result = array_shift($arrays);
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_array($value) || ($value instanceof ArrayAccess && $value instanceof Iterator)) {
                    if (isset($result[$key])) {
                        if (is_array($result[$key]) || ($result[$key] instanceof ArrayAccess && $result[$key] instanceof Iterator)) {
                            $result[$key] = self::merge($result[$key], $value);
                        } else {
                            $result[$key] = $value;
                        }
                    } else {
                        $result[$key] = $value;
                    }
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}

