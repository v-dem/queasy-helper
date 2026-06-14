<?php

namespace queasy\helper;

use Exception;

class MethodNotFoundException extends Exception
{
    protected $method;
    protected $class;

    public function __construct(string $class, string $method, string $message = null)
    {
        $this->class = $class;
        $this->method = $method;

        if (!$message) {
            $message = "The method '{$method}' was not found on the class '{$class}'.";
        }

        parent::__construct($message);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getClass()
    {
        return $this->class;
    }
}

