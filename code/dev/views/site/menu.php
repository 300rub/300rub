<?php
/**
 * Variables
 *
 * @var array $menu
 */

$ulString = '';
foreach ($menu as $item) {
    $tagA = sprintf(
        '<a href="%s"><span>%s</span></a>',
        $item['uri'],
        $item['name']
    );

    $activeClass = '';
    if ($item['isActive'] === true) {
        $activeClass = ' class="active"';
    }

    $tagLi = sprintf(
        '<li%s>%s</li>',
        $activeClass,
        $tagA
    );

    $ulString .= $tagLi;
}

echo sprintf(
    '<ul class="menu">%s</ul>',
    $ulString
);
