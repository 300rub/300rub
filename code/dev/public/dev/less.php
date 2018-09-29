<?php

echo "<pre>";

$startTime = microtime(true);

$path = __DIR__ . '/../less';

$directory = new \RecursiveDirectoryIterator($path);
$iterator = new \RecursiveIteratorIterator($directory);

$filesContent = [];
$parentMap = [];

foreach ($iterator as $info) {
    $path = realpath($info->getPathname());

    if (strpos($path, '.less') === false
        || $path === false
    ) {
        continue;
    }

    $parentMap[$path] = [];
    $content = file_get_contents($path);

    preg_match_all('/\@import\s\"[a-zA-Z0-9\.\/_-]+\"\;/', $content, $matches);

    if (count($matches[0]) > 0) {
        foreach ($matches[0] as $match) {
            $parent = realpath(
                sprintf(
                    '%s/%s.less',
                    dirname($path),
                    str_replace(['@import "', '";', '.less'], '', $match)
                )
            );

            if ($parent !== false) {
                $parentMap[$path][] = $parent;
            }
        }

        $content = str_replace($matches[0], '', $content);
    }

    $filesContent[$path] = $content;
}


var_dump($parentMap);

$time = number_format((microtime(true) - $startTime), 4);
var_dump($time);

exit();

sleep(5);

require __DIR__ . '/../../vendor/leafo/lessphp/lessc.inc.php';

$less = new lessc;

header('Content-type: text/css; charset: UTF-8');
echo $less->compileFile(__DIR__ . '/../less/' . $_GET['name'] . '.less');
