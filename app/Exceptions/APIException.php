<?php

namespace App\Exceptions;

use Exception;

class APIException extends Exception
{
    protected $errors;
    protected $statusCode;

    public function __construct($errors, $statusCode)
    {
        if (is_string($errors)) {
            $this->errors = [$errors];
        } else {
            $this->errors = $errors;
        }

        $this->statusCode = $statusCode;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}