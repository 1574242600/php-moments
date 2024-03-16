<?php

namespace Utils\Database;

class Install
{
    public static function run(\Medoo\Medoo $d)
    {

        $d->create('rss', [
            'id' => [
                'INT',
                'UNSIGNED',
                'NOT NULL',
                'AUTO_INCREMENT',
                'PRIMARY KEY'
            ],
            'name' => [
                'VARCHAR(50)',
                'NOT NULL'
            ],
            'url' => [
                'TEXT',
                'UNIQUE',
                'NOT NULL'
            ],
            'last_scan' => [
                'TIMESTAMP',
                'NULL',
                'DEFAULT NULL'
            ],
            'avatar' => [
                'TEXT',
                'NULL',
                'DEFAULT NULL'
            ]
        ]);

        $d->create('items', [
            'id' => [
                'INT',
                'UNSIGNED',
                'NOT NULL',
                'AUTO_INCREMENT',
                'PRIMARY KEY'
            ],
            'rss_id' => [
                'INT',
                'UNSIGNED',
                'NOT NULL',
            ],
            'title' => [
                'TEXT',
                'NOT NULL'
            ],
            'description' => [
                'TEXT',
                'NOT NULL'
            ],
            'url' => [
                'TEXT',
                'UNIQUE',
                'NOT NULL'
            ],
            'date' => [
                'TIMESTAMP',
                'NULL',
                'DEFAULT NULL'
            ],
        ]);

        /*
        $d->query('
            ALTER TABLE `items`
                ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`rss_id`) REFERENCES `rss` (`id`);
            COMMIT;
        ')
        */
    }
}
