<?php

namespace Controller\Api\Admin;

use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Utils\Abstract\Controller;
use Utils\Exception\InvalidParamsApiException;
use Utils\Rss;

class RssPostController extends Controller
{
    public function __invoke(Request $request, Response $response): Response
    {
        $json = $this->validate($request->getParsedBody());
        $rss = self::validateRss($json['url']);
        $rssDb = $this->getModel('Rss');

        $data = [
            'name' => $rss->getFeed()->getTitle(),
            'url' => $json['url'],
            'avatar' => array_key_exists('avatar', $json) ? $json['avatar'] : null
        ];

        try {
            $data['id'] = $rssDb->insert($data);
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new InvalidParamsApiException("RSS feed already exists ({$json['url']})");
            }

            throw $e;
        }
        
        
        return $this->view($response, 'Api\\Success', [
            'data' => $data
        ]);
    }

    private static function validateRss(string $url) {
        try {
            return Rss::fetch($url);
        } catch (\Exception $e) {
            throw new InvalidParamsApiException('Not a valid RSS feed: ' . $e->getMessage());
        }
    }

    protected function validator(): v
    {
        // @phpstan-ignore-next-line
        return v::keySet(
            //v::key('name', v::stringType()->length(1, 50), false),
            v::key('url', v::anyOf(
                v::Url()->startsWith('http://'),
                v::Url()->startsWith('https://')
            )),
            v::key('avatar', v::anyOf(
                v::Url()->startsWith('http://'),
                v::Url()->startsWith('https://')
            ), false)
        );
    }
}
