<?php

namespace ss\commands\files;

use Aws\Ssm\SsmClient;
use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 *  Command to update staging
 */
class UpdateStagingCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $awsClient = App::getInstance()
            ->getConfig()
            ->getValue(['aws', 'client']);

        $ssmClient = new SsmClient(
            [
                'profile' => $awsClient['profile'],
                'region'  => $awsClient['region'],
                'version' => $awsClient['version'],
            ]
        );

        $result = $ssmClient->sendCommand(
            [

            ]
        );

        var_dump($result);
    }
}
