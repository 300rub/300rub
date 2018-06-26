<?php

namespace ss\commands\common;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Flush Memcached command
 */
class FlushMemcachedCommand extends AbstractCommand
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
