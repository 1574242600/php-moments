<?php

namespace Utils;

use GuzzleHttp\Client as GuzzleClient;
use FeedIo\Adapter\Http\Client as FeedIoClient;
use \FeedIo\FeedIo;
use \FeedIo\Reader\Result;

class Rss
{

    public static function fetch(string $url): Result
    {
        try {
            $c = new FeedIoClient(new GuzzleClient(
                [
                    'headers' => ['User-Agent' => 'php-moments/alpha (+https://github.com/1574242600/php-moments)']
                ]
            ));

            return (new FeedIo($c))->read($url);
        } catch (\Exception $e) {
            throw new \Exception('Fetch rss: ' . $e->getMessage());
        }
    }
}
