<?php

namespace queasy\helper;

use Exception;

class Filter
{
    public static function filter(array $data, array $rules)
    {
        $filter = new Filter($rules);

        return $filter->filter($data);
    }

    private $rules;

    public function __construct(array $rules = array())
    {
        $this->rules = $rules;
    }

    public function filter(array $data = array())
    {
        $result = array();
        foreach ($rules as $ruleKey => $rule) {
            if (is_int($ruleKey)) {
                $result[$rule] = $data[$rule] ?? null;
            } elseif (is_string($ruleKey) && is_callable($rule)) {
                $result[$ruleKey] = $rule($data[$ruleKey]);
            } else {
                throw new Exception('Wrong rule type ' . get_class($rule));
            }
        }

        return $result;
    }
}

