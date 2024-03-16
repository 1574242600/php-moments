<?php

use Utils\Logger\Cron;
use Utils\Rss;
use Model\{Rss as RssDB, Items as ItemsDB};

require_once '../init.php';

class Main {
    private $rssDB;
    private $itemsDB;
    private $logger;

    public function __construct($config, $container)
    {
       
        $db = $container->get('database');

        $this->logger = Cron::init($config);
        $this->rssDB = new RssDB($db);
        $this->itemsDB = new ItemsDB($db);
    }

    public function run()
    {
        //todo 重构
        $rssList = $this->rssDB->selectWithAllColumn();

        foreach ($rssList as $rss) {
            ['id' => $id, 'name' => $name, 'url'=> $url ] = $rss;
            $lastScan = is_null($rss['last_scan']) ? new DateTime(date(DATE_ATOM, 0)) : new DateTime($rss['last_scan']);

            $this->logger->info("Start scanning [{$name}]({$url}). last_scan: {$lastScan->format(DATE_ATOM)}");
            $items = $this->scanRssItems($url, $lastScan);

            $DBdata = $this->itemsToDBData($items, $id);

            $this->rssDB->action(function() use ($id, $DBdata) {
                foreach ($DBdata as $data) {
                    $this->itemsDB->insert($data);
                }

                $this->rssDB->updateLastScan(['id' => $id]);
            });
        }
    }

    private function itemsToDBData($items, $id) {
        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'rss_id' => $id,
                'title' => $item->getTitle(),
                'description' => $item->getContent(),
                'url' => $item->getLink(),
                'date' => $item->getLastModified()
                    ->setTimezone(new DateTimeZone(date_default_timezone_get()))
                    ->format('Y-m-d H:i:s')
            ];
        }

        return $data;
    }
    
    private function scanRssItems($url, $lastScan = null) {
        return Rss::fetch($url)->getItemsSince($lastScan);
    }
}

$main = new Main($config, $container);
$main->run();