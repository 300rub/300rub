<?php

namespace ss\commands\prod;

use Aws\Ssm\SsmClient;
use ss\application\App;
use ss\application\exceptions\FileException;
use ss\commands\_abstract\AbstractCommand;

/**
 *  Command to generate config file
 */
class GenerateConfigCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     *
     * @throws FileException
     */
    public function run()
    {
        $filePath = CODE_ROOT . '/config/env/prod.json';
        $content = file_get_contents($filePath);

        preg_match_all('/\{\{[a-zA-Z]+\}\}/', $content, $matches);
        $matches = $matches[0];

        $names = [];
        foreach ($matches as $match) {
            $names[] = str_replace(['{', '}'], '', $match);
        }

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

        $result = $ssmClient->getParameters(
            [
                'Names' => $names,
            ]
        );

        $nameValueList = [];
        foreach ($result['Parameters'] as $parameter) {
            $nameValueList[$parameter['Name']] = $parameter['Value'];
        }

        foreach ($matches as $match) {
            $name = str_replace(['{', '}'], '', $match);
            if (array_key_exists($name, $nameValueList) === false) {
                continue;
            }

            $content = str_replace($match, $nameValueList[$name], $content);
        }

        file_put_contents($filePath, $content);
    }
}
