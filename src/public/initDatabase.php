<?php

require_once '../init.php';

use Utils\Database\Install;

$db = $container->get('database');

$isInit = $db->query("SHOW TABLES like 'rss'")->rowCount() > 0
        && $db->query("SHOW TABLES like 'items'")->rowCount() > 0;


if($isInit) {
    die();
}

Install::run($db);

echo 'success';
