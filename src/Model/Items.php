<?php

namespace Model;

use Utils\Abstract\Db;

class Items extends Db
{
    private static $table = 'items';

    private static $columns = [
        'id',
        'rss_id',
        'title',
        'description',
        'url',
        'date'
    ];

    public function selectWithAllColumn(array $where = []): array | null
    {
        return $this->select(self::$columns, $where);
    }

    public function selectByIdBetween(int $start, int $end, array $order): array | null
    {
        return $this->selectWithAllColumn([
            'id[<>]' => [$start, $end],
            'ORDER' => $order
        ]);
    }

    
    protected function getTable(): string
    {
        return self::$table;
    }
}
