<?php

namespace ss\commands\prod;

use ss\commands\prod\_abstract\AbstractRunCommand;

/**
 *  Command to update staging
 */
class UpdateStagingCommand extends AbstractRunCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $commands = [
            'mkdir -p /var/www/archives',
            'mkdir -p /var/www/archives/staging',
            'mkdir -p /var/www/staging',
            'mkdir -p /var/www/staging/code',
            'mkdir -p -m 0777 /var/www/staging/logs',
            'rm -rf /var/www/archives/staging/code',
            'cd /var/www/archives/staging',
            'aws s3 cp s3://supers-releases/staging.tar.gz staging.tar.gz',
            'tar -xzf /var/www/archives/staging/staging.tar.gz',
            'rsync -azh /var/www/archives/staging/code /var/www/staging --delete',
            'cd /var/www/staging/logs',
            'find . -type f -exec sh -c \'>{}\' \;',
        ];

        $this->runCommands($commands);
    }
}
