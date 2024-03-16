<?php

namespace Utils\Exception;

class UnauthorizedApiException extends \Exception
{
    protected $code = 401;
    protected $message = 'Invalid token';
}
