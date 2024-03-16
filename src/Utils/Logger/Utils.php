<?php

namespace Utils\Logger;

use Psr\Http\Message\ServerRequestInterface as Request;

class Utils
{
    public static function toRequestDebugContext(Request $request)
    {
        return [
            'Querys' => $request->getUri()->getQuery(),
            'Headers' => $request->getHeaders(),
            'Body' => $request->getParsedBody()
        ];
    }
}
