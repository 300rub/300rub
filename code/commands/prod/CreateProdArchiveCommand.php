<?php

namespace ss\commands\prod;

use ss\commands\prod\_abstract\AbstractRunCommand;

/**
 *  Command to create prod archive
 */
class CreateProdArchiveCommand extends AbstractRunCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $commands = [
            'aws s3 cp /var/www/archives/staging/staging.tar.gz s3://supers-releases/prod.tar.gz',
        ];

        $this->runCommands($commands);
    }
}
