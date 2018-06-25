<?php

if (getenv('APP_ENV') === 'dev') {
    exec('php ' . __DIR__ . '/../../bin/run-php-command clearDb');
    exec('php ' . __DIR__ . '/../../bin/run-php-command migrate');
    exec('php ' . __DIR__ . '/../../bin/run-php-command loadFixtures');

    echo '<div id="ok">OK</div>';
}
