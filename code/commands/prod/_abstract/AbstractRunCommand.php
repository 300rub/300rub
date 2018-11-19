<?php

namespace ss\commands\prod\_abstract;

use Aws\AutoScaling\AutoScalingClient;
use Aws\Ssm\SsmClient;
use ss\application\App;
use ss\application\exceptions\CommonException;
use ss\commands\_abstract\AbstractCommand;

/**
 * Abstract class to run and check command
 */
abstract class AbstractRunCommand extends AbstractCommand
{

    /**
     * Attempts
     */
    const ATTEMPTS = 30;

    /**
     * Check timeout
     */
    const CHECK_TIMEOUT = 2;

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
     * Commands
     *
     * @var string[]
     */
    private $_commands = [];

    /**
     * Runs command
     *
     * @param string[] $commands List of commands
     *
     * @return AbstractRunCommand
     */
    protected function runCommands($commands)
    {
        return $this
            ->_setCommands($commands)
            ->_setInstanceIds()
            ->_runCommand()
            ->_checkStatus();
    }

    /**
     * Sets commands
     *
     * @param string[] $commands List of commands
     *
     * @return AbstractRunCommand
     */
    private function _setCommands($commands)
    {
        $this->_commands = $commands;
        return $this;
    }

    /**
     * Sets instance IDs
     *
     * @return AbstractRunCommand
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
     * @return AbstractRunCommand
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
                'Comment'        => 'Hello comment',
                'DocumentName'   => 'AWS-RunShellScript',
                'MaxConcurrency' => '100%',
                'MaxErrors'      => '1',
                'Parameters'     => [
                    'commands' => $this->_commands,
                ],
                'Targets'        => [
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
     * @return AbstractRunCommand
     *
     * @throws CommonException
     */
    private function _checkStatus($attempt = 1)
    {
        if ($attempt > self::ATTEMPTS) {
            return $this;
        }

        sleep(self::CHECK_TIMEOUT);

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
