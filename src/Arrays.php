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

                continue;
            }

            $result = array_merge($result, array($key => $value));
        }

        return $result;
    }

    /**
     * Create a key/value map by column or object field.
     *
     * @param array|ArrayAccess $rows Array (or ArrayAccess object) of arrays (or ArrayAccess objects) or objects
     * @param string $columnKey Column name
     * @param string $indexKey Index name
     *
     * @return array Array containing $field values as a keys and associated rows as a values
     */
    public static function column($rows, $columnKey = null, $indexKey = null)
    {
        $result = array();
        foreach ($rows as $row) {
            if (is_array($row) || is_object($row) && ($row instanceof ArrayAccess)) {
                $isLikeArray = true;
            } elseif (is_object($row)) {
                $isLikeArray = false;
            } else {
                throw new InvalidArgumentException('Unexpected value. Must be array (or ArrayAccess) or object.');
            }

            if (null === $columnKey) {
                $value = $row;
            } else {
                $value = $isLikeArray
                    ? $row[$columnKey]
                    : $row->$columnKey;
            }

            if (null === $indexKey) {
                $result[] = $value;
            } else {
                if ($isLikeArray) {
                    $result[$row[$indexKey]] = $value;
                } else {
                    $result[$row->$indexKey] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * Merge arrays or ArrayAccess objects recursively. Arguments can be of type "array" or "object" which implements Iterator and ArrayAccess
     *
     * @param array|ArrayAccess $array1 Array to merge
     * @param array|ArrayAccess $array2 Array to merge
     * @param array|ArrayAccess ...
     *
     * @return array|ArrayAccess Merged array (type will be the same as the first argument)
     */
    public static function merge()
    {
        $arrays = func_get_args();
        $result = array_shift($arrays);
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if ((is_array($value) || ($value instanceof ArrayAccess && $value instanceof Iterator))
                        && isset($result[$key])
                        && (is_array($result[$key]) || ($result[$key] instanceof ArrayAccess && $result[$key] instanceof Iterator))) {
                    $result[$key] = self::merge($result[$key], $value);
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}

