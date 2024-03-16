<?php

namespace Utils\Exception;

class InvalidParamsApiException extends \Exception
{
    protected $code = 400;
    protected $message = 'Invalid parameters: ';

    public function __construct(string $msg)
    {
        $this->message .= $msg;
    }
}
