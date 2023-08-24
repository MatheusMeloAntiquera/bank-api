<?php

namespace App\Exceptions;

use Exception;

abstract class WithHttpsCodeException extends Exception
{
    public $statusCode = 500;
}
