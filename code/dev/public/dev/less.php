<?php

require __DIR__ . '/../../vendor/leafo/lessphp/lessc.inc.php';
require __DIR__ . '/../../application/components/file/Less.php';

use ss\application\components\file\Less;

header('Content-type: text/css; charset: UTF-8');

$less = new Less($_GET['type']);
echo $less->getCss();
