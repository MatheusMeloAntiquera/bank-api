<?php

namespace App\Exceptions;

class TransactionNotAuthorizedException extends WithHttpsCodeException
{
    public $statusCode = 403;
}
