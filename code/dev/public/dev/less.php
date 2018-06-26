<?php

require __DIR__ . '/../../vendor/leafo/lessphp/lessc.inc.php';

$less = new lessc;

header('Content-type: text/css; charset: UTF-8');
echo $less->compileFile(__DIR__ . '/../less/' . $_GET['name'] . '.less');
