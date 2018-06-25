<?php

/**
 * Variables
 *
 *  @var string $container
 *  @var int    $blockId
 */

echo sprintf('$("%s .autoload").each(function(){', $container);

echo 'var options = {};';
echo 'options.group = "record";';
echo 'options.controller = "content";';
echo 'options.element = $(this);';
echo 'options.container = $(this).parent().find(".instances");';
echo sprintf('options.blockId = %s;', $blockId);

echo 'new ss.components.Autoload(options);';

echo '});';
?>
