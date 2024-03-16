<?php

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteCollectorProxy;
use Controller\Api\Admin\{ RssPostController, RssDelController, RssGetController };
use Controller\Api\ItemsGetController;

$api = $app->group('/api', function (RouteCollectorProxy $g) {
    $g->options('/{routes:.+}', function ($_, Response $response) {
        return $response;
    });

    $g->get('/items', ItemsGetController::class);
    
    $admin = $g->group('/admin', function (RouteCollectorProxy $g) {
        $g->post('/rss', RssPostController::class);
        $g->get('/rss', RssGetController::class);
        $g->delete('/rss/{id:[0-9]+}', RssDelController::class);
    });

    global $config;
    $admin->add(new Middleware\ApiAuth($config['api_token']));
});

$api->add(new Middleware\JsonBodyParser());
$api->add(new Middleware\ContentType('application/json; charset=utf-8'));
$api->add(new Middleware\CORS($config['allow-origin']));


$app->any('/{routes:.+}', function ($_, Response $response) {
    $response->withStatus(404);
    $response->getBody()->write('Page not found');

    return $response;
});