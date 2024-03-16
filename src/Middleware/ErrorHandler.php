<?php

namespace Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use View\Api\Error as ErrorView;
use Utils\Logger\Utils;

class ErrorHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(
        Request $request,
        \Throwable $exception,
    ): Response {
        $code = $this->getCode($exception);
        $this->log($code, $exception->getMessage(), $request);

        $response = AppFactory::create()->getResponseFactory()->createResponse($code);

        $response->getBody()->write(ErrorView::render([ 'msg' => $exception->getMessage() ]));

        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    private function log(int $code, string $msg, Request $request): void
    {
        $info = "{$code} {$request->getMethod()} {$request->getUri()->getPath()} ";

        $this->logger->error($info . $msg);
        $this->logger->debug('Request', Utils::toRequestDebugContext($request));
    }

    private function getCode(\Throwable $exception): int
    {
        $code = $exception->getCode();

        if (!is_int($code)) return 500;
        return $code === 0 || $code > 599 ? 500 : $code;
    }
}
