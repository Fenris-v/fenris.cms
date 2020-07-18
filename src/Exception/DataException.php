<?php

namespace App\Exception;

use Exception;
use Throwable;

class DataException extends Exception
{
    public static array $errors;

    public function __construct($errors, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        self::$errors = $errors;
    }
}
