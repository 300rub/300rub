<?php

namespace ss\commands\prod;

use ss\commands\prod\_abstract\AbstractRunCommand;

/**
 *  Command to update prod
 */
class UpdateProdCommand extends AbstractRunCommand
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
            'mkdir -p /var/www/archives/prod',
            'mkdir -p /var/www/prod',
            'mkdir -p /var/www/prod/code',
            'mkdir -p -m 0777 /var/www/prod/logs',
            'rm -rf /var/www/archives/prod/code',
            'cd /var/www/archives/prod',
            'aws s3 cp s3://supers-releases/prod.tar.gz prod.tar.gz',
            'tar -xvzf /var/www/archives/prod/prod.tar.gz',
            'rsync -avzh /var/www/archives/prod/code /var/www/prod --delete',
        ];

        $this->runCommands($commands);
    }
}
