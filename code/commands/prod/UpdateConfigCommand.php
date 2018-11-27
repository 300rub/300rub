<?php

namespace ss\commands\prod;

use ss\commands\prod\_abstract\AbstractRunCommand;

/**
 *  Command to reload nginx
 */
class UpdateConfigCommand extends AbstractRunCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $commands = [
            'cp /var/www/prod/code/config/prod/php/config.ini /etc/php/7.2/fpm/conf.d/config.ini',
            'cp /var/www/prod/code/config/prod/php/php-fpm.conf /etc/php/7.2/fpm/php-fpm.conf',
            'cp /var/www/prod/code/config/prod/nginx/nginx.conf /etc/nginx/nginx.conf',
            'cp /var/www/prod/code/config/prod/logs/awslogs.conf /var/awslogs/etc/awslogs.conf',
            'service php7.2-fpm reload',
            'service nginx reload',
            'service awslogs restart',
        ];

        $this->runCommands($commands);
    }
}
