<?php

namespace ss\commands\prod;

use ss\commands\prod\_abstract\AbstractRunCommand;

/**
 *  Command to reload nginx
 */
class ReloadNginxCommand extends AbstractRunCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $commands = [
            'nginx -s reload',
        ];

        $this->runCommands($commands);
    }
}
