<?php

namespace View\Api;

use Utils\Interface\View;

class Success implements View
{
    public static function render(array $params): string
    {
        return json_encode([
            'data' => $params['data']
        ]);
    }
}
