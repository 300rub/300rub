<?php

namespace testS\commands;

use testS\application\App;
use testS\commands\_abstract\AbstractCommand;

/**
 * Clear Memcached command
 */
class ClearMemcachedCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        App::getInstance()->getMemcached()->flush();
    }
}
