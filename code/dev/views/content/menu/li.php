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
        $levelClass = 'first-level';
        break;
    case 2:
        $levelClass = 'second-level';
        break;
    default:
        $levelClass = 'last-level';
        break;
}

if ($isActive === true) {
    $levelClass .= '-active';
}

echo sprintf(
    '<li><a href="%s" class="%s">%s</a>%s</li>',
    $url,
    $levelClass,
    $name,
    $children
);
