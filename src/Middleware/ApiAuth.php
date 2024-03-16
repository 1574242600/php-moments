<?php

namespace Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Utils\Interface\Middleware;
use Utils\Exception\UnauthorizedApiException;

class ApiAuth implements Middleware
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token = ApiAuth::getToken($request);

        if (!($token === $this->token)) {
            throw new UnauthorizedApiException();
        }

        return $handler->handle($request);
    }

    private static function getToken(Request $request): string | null
    {
        $token = $request->getHeaderLine('Authorization');

        return strlen($token) === 0 ? null : substr($token, 7);
    }
}
