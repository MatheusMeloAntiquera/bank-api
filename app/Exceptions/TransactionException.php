<?php

namespace App\Exceptions;

class TransactionException extends WithHttpsCodeException
{
    public $statusCode = 500;
}
