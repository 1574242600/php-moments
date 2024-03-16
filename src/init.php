<?php
declare(strict_types=1);

use DI\Container;
use Medoo\Medoo;

require __DIR__ . '/../vendor/autoload.php';
function globalExceptionHandler(Throwable $e): void
{
    http_response_code(500);
    header("Content-Type:application/json; charset=utf-8");

    die(json_encode([
        'msg' => 'Uncaught Exception: ' . $e->getMessage()
    ]));
}

set_exception_handler('globalExceptionHandler');

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' .  str_replace('\\', '/', $class . '.php');

    if (file_exists($path)) {
        include $path;
    }
});

$config = require_once('config.inc.php');

//if (!$config['dev']) log_errors(1);

$container = new Container();
$container->set('database', function () use ($config) {
    return new Medoo($config['database']);
});
