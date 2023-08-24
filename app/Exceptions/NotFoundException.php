<?php

namespace App\Exceptions;

use App\Exceptions\WithHttpsCodeException;

class NotFoundException extends WithHttpsCodeException
{
    public $statusCode = 404;
}
