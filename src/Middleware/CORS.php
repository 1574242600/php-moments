<?php

namespace Middleware;

use Utils\Interface\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CORS implements Middleware
{
    private array $allowOrigin;

    public function __construct(array $allowOrigin)
    {
        $this->allowOrigin = $allowOrigin;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        return $handler->handle($request)
            ->withHeader('Access-Control-Allow-Headers', 'Authorization')
            ->withHeader('Access-Control-Allow-Methods', '*')
            ->withHeader('Access-Control-Allow-Origin', CORS::getAllowOrigin($this->allowOrigin));
    }

    private static function getAllowOrigin($domains = []): string
    {
        $domain = $domains[0];

        if (empty($_SERVER['HTTP_ORIGIN'])) {
            return $domain;
        }
        if (empty($domains)) {
            return '*';
        }


        foreach ($domains as $v) {
            if ($v == $_SERVER['HTTP_ORIGIN']) {
                $domain = $v;
                break;
            }
        }

        return $domain;
    }
}
