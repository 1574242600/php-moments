<?php

namespace View\Api;

use Utils\Interface\View;
use Utils\Date;

class ItemsGet implements View
{
    public static function render(array $params): string
    {
        foreach ($params['list'] as $k => $item) {
            $params['list'][$k] = [
                'id' => $item['id'],
                'rssId' => $item['rss_id'],
                'title' => $item['title'],
                'description' => $item['description'],
                'url' => $item['url'],
                'date' => Date::strToTimestamp($item['date'])
            ];
        }

        return json_encode($params);
    }
}
