<?php

namespace ss\commands\files;

use Aws\AutoScaling\AutoScalingClient;
use Aws\Command;
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

        $autoScalingClient = new AutoScalingClient(
            [
                'profile' => $awsClient['profile'],
                'region'  => $awsClient['region'],
                'version' => $awsClient['version'],
            ]
        );

        $result = $autoScalingClient->execute(
            new Command(
                'mkdir',
                [
                    '/var/www/html/test'
                ]
            )
        );

        var_dump($result);

//        $ssmClient = new SsmClient(
//            [
//                'profile' => $awsClient['profile'],
//                'region'  => $awsClient['region'],
//                'version' => $awsClient['version'],
//            ]
//        );
//
//        $result = $ssmClient->sendCommand(
//            [
//                'Comment'         => 'Hello comment',
//                'DocumentName'    => 'AWS-RunShellScript',
//                'DocumentVersion' => '$DEFAULT',
//                'MaxConcurrency'  => '100%',
//                'MaxErrors'       => '1',
//                'Parameters'      => [
//                    'commands'         => [
//                        'mkdir /var/www/html/test',
//                    ],
//                     'executionTimeout' => ['5'],
//                    'workingDirectory' => ['/var/www'],
//                ],
//                'Targets'         => [
//                    [
//                        'Key'    => 'tag:aws:autoscaling:groupName',
//                        'Values' => [
//                            'Simple-Group'
//                        ],
//                    ],
//                ],
//                'TimeoutSeconds' => 30
//            ]
//        );


    }
}
