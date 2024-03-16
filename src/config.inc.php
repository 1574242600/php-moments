<?php

return [
    'database' => [
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'dev',
        'username' => 'dev',
        'password' => 'dev',
        'port' => 3306,
    ],
    'api_token' => 'dev',
    'allow-origin' => ['http://localhost'],
    'log_level' => 200,
    'logs_dir' => __DIR__ . '/logs',
    'dev' => true
];
