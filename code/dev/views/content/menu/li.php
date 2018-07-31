<?php

/**
 * Variables
 *
 * @var bool   $isActive
 * @var string $url
 * @var string $name
 * @var int    $level
 * @var string $children
 */

switch ($level) {
    case 1:
        $cssClass = 'first-level';
        break;
    case 2:
        $cssClass = 'second-level';
        break;
    default:
        $cssClass = 'last-level';
        break;
}

if ($isActive === true) {
    $cssClass .= '-active';
}

$href = sprintf('href="%s"', $url);

if ($url === null) {
    $href = '';
    $cssClass .= ' empty';
}

echo sprintf(
    '<li><a %s class="%s">%s</a>%s</li>',
    $href,
    $cssClass,
    $name,
    $children
);
