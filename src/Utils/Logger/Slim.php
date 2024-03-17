<?php

namespace Utils\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Slim
{
    private static $logger = null;

    public static function init(array $config)
    {
        if (!is_null(self::$logger)) {
            return self::$logger;
        }

        $logStream = new StreamHandler($config['logs_dir']. '/slim.log', $config['dev'] ? 100 : $config['lo_level']);

        self::$logger = new Logger('slim');
        self::$logger->pushHandler($logStream);

        return self::$logger;
    }
}
