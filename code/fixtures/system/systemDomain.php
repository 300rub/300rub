<?php

use ss\application\App;

$list = [];

$domains = App::getInstance()->getConfig()->getValue(['domains']);
foreach ($domains as $domain) {
    $list[] = [
        'siteId' => $domain['siteId'],
        'name'   => $domain['name'],
        'isMain' => $domain['isMain'],
    ];
}

return $list;
