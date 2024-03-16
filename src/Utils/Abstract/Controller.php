<?php

namespace Utils\Abstract;

use Respect\Validation\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Utils\Exception\InvalidParamsApiException;
use Monolog\Logger;
use Medoo\Medoo;

abstract class Controller
{
    protected Logger $logger;

    private Medoo $db;
    
    abstract public function __invoke(Request $request, Response $response): Response;
    abstract protected function validator(): Validator;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->db = $container->get('database');
    }

    final protected function validate(mixed $data): mixed
    {
        try {
            $validator = $this->validator();
            $validator->check($data);

            return $data;
        } catch (\Exception $e) {
            throw new InvalidParamsApiException($e->getMessage());
        }
    }

    final protected function getModel(string $name): object
    {
        $class = "\\Model\\{$name}";

        return new $class($this->db);
    }

    final protected function view(Response $response, string $name, array $data): Response
    {
        $class = "\\View\\{$name}";
        $response->getBody()->write($class::render($data));
        
        return $response;
    }
}
