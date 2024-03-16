<?php

namespace Model;

use Utils\Abstract\Db as DB;
use Medoo\Medoo;

class Rss extends DB
{
    private static $table = 'rss';

    private static $columns = [
        'id',
        'name',
        'url',
        'last_scan',
        'avatar'
    ];

    public function selectWithAllColumn(array $where = []): array | null
    {
        return $this->select(self::$columns, $where);
    }

    public function selectByIdBetween(int $start, int $end): array | null
    {
        return $this->selectWithAllColumn([
            'id[<>]' => [$start, $end]
        ]);
    }

    public function updateLastScan($where, $lastScan = null) {
        return $this->update([
            'last_scan' => is_null($lastScan) ? Medoo::raw('now()') : $lastScan
        ], $where);
    }

    protected function getTable(): string 
    {
        return self::$table; 
    }
}
