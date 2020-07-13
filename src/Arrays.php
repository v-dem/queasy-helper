<?php

namespace queasy\helper;

use InvalidArgumentException;

class Arrays
{
    /**
     * Convert a multi-dimensional array to single-dimensional.
     *
     * @param array Source multi-dimensional array
     *
     * @return array Single-dimensional array
     */
    public static function flatten($array)
    {
        $result = array();

        if (!is_array($array)) {
            $array = func_get_args();
        }

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
}

