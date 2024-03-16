<?php

namespace View\Api;

use Utils\Interface\View;

class Error implements View
{
    public static function render(array $params): string
    {
        return json_encode([
            'msg' => $params['msg']
        ]);
    }
}
