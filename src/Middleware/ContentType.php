<?php

namespace Middleware;

use Utils\Interface\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ContentType implements Middleware
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        return $handler->handle($request)
            ->withHeader('Content-Type', $this->value);
    }
}
