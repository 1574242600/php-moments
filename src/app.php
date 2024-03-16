<?php
require_once 'init.php';

use Slim\Factory\AppFactory;
use Utils\Logger\Slim;

$container->set('logger', function () use ($config) {
    return Slim::init($config);
});

AppFactory::setContainer($container);

$app = AppFactory::create();
$errorMiddleware = $app->addErrorMiddleware($config['dev'], true, true/*, $logger*/);
$errorMiddleware->setDefaultErrorHandler(new Middleware\ErrorHandler($container->get('logger')));

require_once 'router.php';
