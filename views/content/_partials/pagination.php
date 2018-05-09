<?php

/**
 * Variables
 *
 * @var int    $lastPage
 * @var int    $currentPage
 * @var int    $blockId
 * @var array  $parameters
 * @var string $url
 */

$itemSize = 10;
$halfSize = ($itemSize / 2);
$lastPage = (int)$lastPage;
$firstPage = 1;
$currentPage = (int)$currentPage;
if ($currentPage < 1) {
    $currentPage = 1;
}

$beforeCount = ($currentPage - $firstPage);
$afterCount = ($lastPage - $currentPage);

$fromPage = $firstPage;
$toPage = $lastPage;

if (is_array($parameters) === false) {
    $parameters = [];
}

if (array_key_exists('page', $parameters) === true) {
    unset($parameters['page']);
}

if (array_key_exists('block', $parameters) === true) {
    unset($parameters['block']);
}

if (($toPage - $fromPage) >= $itemSize) {
    if ($beforeCount < $afterCount) {
        if ($beforeCount <= $halfSize) {
            $fromPage = $firstPage;
            $toPage = ($currentPage + ($itemSize - $beforeCount) - 1);
        }

        if ($beforeCount > $halfSize) {
            $fromPage = ($currentPage - $halfSize);
            $toPage = ($currentPage + $halfSize - 1);
        }
    }

    if ($afterCount <= $beforeCount) {
        if ($afterCount <= $halfSize) {

            $toPage = $lastPage;
            $fromPage = ($currentPage - ($itemSize - $afterCount - 1));
            var_dump($fromPage);
        }

        if ($afterCount > $halfSize - 1) {
            $toPage = ($currentPage + $halfSize - 1);
            $fromPage = ($currentPage - $halfSize);
        }
    }
}

$fromPage = (int) $fromPage;
$toPage = (int) $toPage;

if ($lastPage !== 1) {
    echo '<div>';

//    if ($currentPage !== 1) {
//        echo sprintf(
//            '<a href="%s" class="%s">%s</a> ',
//            $linkUrl,
//            $activeClass,
//            $page
//        );
//    }

    for ($page = $fromPage; $page <= $toPage; $page++) {
        $activeClass = '';
        if ($page === $currentPage) {
            $activeClass = 'active';
        }

        $linkParameters = $parameters;

        if ($page !== 1) {
            $linkParameters['block'] = $blockId;
            $linkParameters['page'] = $page;
        }

        if ($page === 1
            && count($linkParameters) > 0
        ) {
            $linkParameters['block'] = $blockId;
        }

        $linkUrl = $url;
        if (count($linkParameters) > 0) {
            $linkUrl = sprintf(
                '%s?%s',
                $linkUrl,
                http_build_query($linkParameters)
            );
        }

        echo sprintf(
            '<a href="%s" class="%s">%s</a> ',
            $linkUrl,
            $activeClass,
            $page
        );
    }

    echo '</div>';
}
