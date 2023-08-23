<?php

namespace App\Exceptions;

use App\Exceptions\WithHttpsCodeException;

class InvalidArgumentException extends WithHttpsCodeException
{
    public $statusCode = 400;
}
