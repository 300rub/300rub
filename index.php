<?php

/**
 * PHP version 7
 *
 * @category TestS
 * @package  Bootstrap
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

use testS\applications\App;

// Config file path
$config = include __DIR__ . "/config/common.php";

// Runs the web application
require __DIR__ . "/applications/App.php";
App::web($config)->run();