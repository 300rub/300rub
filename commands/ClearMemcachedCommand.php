<?php

namespace ss\commands;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

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
