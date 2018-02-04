<?php

//use testS\application\App;

// Config file path.
//$config = include __DIR__ . '/../config/common.php';

// Runs a command.
require __DIR__ . '/../application/App.php';

spl_autoload_register(['testS\application\App','autoload']);

//App::test($config)->run();
