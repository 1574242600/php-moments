<?php

namespace Controller\Api;

use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Utils\Abstract\Controller;

class ItemsGetController extends Controller
{
    public function __invoke(Request $request, Response $response): Response
    {
        $json = $this->validate($request->getParsedBody());
        $itemsDb = $this->getModel('Items');
        $index = $json['index'] + 1;
        
        $list = $itemsDb->selectByIdBetween($index, $index + $json['offset']);

        $count = $itemsDb->count();


        return $this->view($response, 'Api\\Success', [
            'data' => [
                'list' => $list,
                'total' => $count,
                'index' => $json['index'],
                'offset' => $json['offset']
            ]
        ]);
    }

    protected function validator(): v
    {
        // @phpstan-ignore-next-line
        return v::keySet(
            v::key('index', v::intType()->min(0)),
            v::key('offset', v::intType()->between(0, 50))
            // todo filter sort
        );
    }
}