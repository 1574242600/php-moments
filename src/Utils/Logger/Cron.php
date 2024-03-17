<?php

namespace Utils\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Cron
{
    private static $logger = null;

    public static function init(array $config)
    {
        if (!is_null(self::$logger)) {
            return self::$logger;
        }

        $logStream = new StreamHandler($config['logs_dir'] . '/corn.log', $config['dev'] ? 100 : $config['log_level']);

        self::$logger = new Logger('cron');
        self::$logger->pushHandler($logStream);

        return self::$logger;
    }
}
