<?php

namespace View\Api;

use Utils\Interface\View;
use Utils\Date;

class RssGet implements View
{
    public static function render(array $params): string
    {
        foreach ($params['list'] as $k => $item) {
            $params['list'][$k] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'url' => $item['url'],
                'lastScan' => is_null($item['last_scan']) ? 0 : Date::strToTimestamp($item['last_scan']),
                'avatar' => $item['avatar'],
            ];
        }

        return json_encode($params);
    }
}
