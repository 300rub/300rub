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
                'Comment'         => 'Hello comment',
                'DocumentName'    => 'AWS-RunShellScript',
                'MaxConcurrency'  => '100%',
                'MaxErrors'       => '1',
                'Parameters'      => [
                    'commands'         => [
                        'mkdir /var/www/test4',
                    ],
                    'workingDirectory' => ['/var/www'],
                ],
                'Targets'         => [
                    [
                        'Key'    => 'tag:aws:autoscaling:groupName',
                        'Values' => [
                            'Simple-Group'
                        ],
                    ],
                ],
            ]
        );

        $commandId = $result['Command']['CommandId'];

        sleep(2);

        $result = $ssmClient->listCommandInvocations([
            'CommandId' => $commandId,
        ]);

        foreach ($result['CommandInvocations'] as $commandInvocations) {
            var_dump($commandInvocations['Status']);
        }
    }
}
