<?php

namespace Controller\Api\Admin;

use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Utils\Abstract\Controller;

class RssDelController extends Controller
{
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $id = $this->validate((int)$args['id']);
        $rssDb = $this->getModel('Rss');
        $itemDb = $this->getModel('Items');

        $rssDb->action(function() use($rssDb, $itemDb, $id) {
            $itemDb->delete([
                'rss_id' => $id
            ]);

            $rssDb->delete([
                'id' => $id
            ]);
        });
        
        return $this->view($response, 'Api\\Success', [ 'data' => $args ]);
    }

    protected function validator(): v
    {
        // @phpstan-ignore-next-line
        return v::intType()->min(1);
    }
}
