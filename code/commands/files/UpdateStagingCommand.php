<?php

namespace ss\commands\files;

use Aws\AutoScaling\AutoScalingClient;
use Aws\Ssm\SsmClient;
use ss\application\App;
use ss\application\exceptions\CommonException;
use ss\commands\_abstract\AbstractCommand;

/**
 *  Command to update staging
 */
class UpdateStagingCommand extends AbstractCommand
{

    /**
     * Attempts
     */
    const ATTEMPTS = 30;

    /**
     * Instance IDs
     *
     * @var string[]
     */
    private $_instanceIds = [];

    /**
     * Command ID
     *
     * @var string
     */
    private $_commandId = '';

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $this
            ->_setInstanceIds()
            ->_runCommand()
            ->_checkStatus();
    }

    /**
     * Sets instance IDs
     *
     * @return UpdateStagingCommand
     */
    private function _setInstanceIds()
    {
        $this->_instanceIds = [];

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
        $result = $autoScalingClient->describeAutoScalingInstances([]);

        foreach ($result['AutoScalingInstances'] as $instance) {
            $this->_instanceIds[] = $instance['InstanceId'];
        }

        $this->output(
            sprintf(
                'Instance IDs: %s',
                implode(', ', $this->_instanceIds)
            )
        );

        return $this;
    }

    /**
     * Runs command
     *
     * @return UpdateStagingCommand
     */
    private function _runCommand()
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
                        'mkdir -p /var/www/archives',
                        'mkdir -p /var/www/archives/staging',
                        'mkdir -p /var/www/staging',
                        'mkdir -p /var/www/staging/code',
                        'mkdir -p -m 0777 /var/www/staging/logs',
                        'rm -rf /var/www/archives/staging/code',
                        'cd /var/www/archives/staging',
                        'aws s3 cp s3://supers-releases/staging.tar.gz /var/www/archives/staging/staging.tar.gz',
                        'tar -xvzf /var/www/archives/staging/staging.tar.gz',
                        'rsync -avzh /var/www/archives/staging/code /var/www/staging',

                        'aws s3 cp /var/www/archives/staging/staging.tar.gz s3://supers-releases/prod.tar.gz',

                        'mkdir -p /var/www/archives',
                        'mkdir -p /var/www/archives/prod',
                        'mkdir -p /var/www/staging',
                        'mkdir -p /var/www/staging/prod',
                        'mkdir -p -m 0777 /var/www/prod/logs',
                        'rm -rf /var/www/archives/prod/code',
                        'cd /var/www/archives/prod',
                        'aws s3 cp s3://supers-releases/prod.tar.gz /var/www/archives/prod/prod.tar.gz',
                        'tar -xvzf /var/www/archives/prod/prod.tar.gz',
                        'rsync -avzh /var/www/archives/prod/code /var/www/prod',
                    ],
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

        $this->_commandId = $result['Command']['CommandId'];

        $this->output(
            sprintf(
                'Command ID: %s',
                $this->_commandId
            )
        );

        return $this;
    }

    /**
     * Check status
     *
     * @param int $attempt Attempt
     *
     * @return UpdateStagingCommand
     *
     * @throws CommonException
     */
    private function _checkStatus($attempt = 1)
    {
        if ($attempt > self::ATTEMPTS) {
            return $this;
        }

        sleep(4);

        $this->output(
            sprintf(
                'Checking. %s attempt...',
                $attempt
            )
        );

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

        $result = $ssmClient->listCommandInvocations([
            'CommandId' => $this->_commandId,
        ]);

        if (count($result['CommandInvocations']) < count($this->_instanceIds)) {
            return $this->_checkStatus($attempt + 1);
        }

        foreach ($result['CommandInvocations'] as $commandInvocations) {
            $status = $commandInvocations['Status'];

            if ($status === 'InProgress') {
                return $this->_checkStatus($attempt + 1);
            }

            if ($status !== 'Success') {
                throw new CommonException('Error');
            }
        }

        $this->output('Success');

        return $this;
    }
}
