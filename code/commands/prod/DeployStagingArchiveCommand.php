<?php

namespace ss\commands\prod;

use ss\application\App;
use ss\application\exceptions\FileException;
use ss\commands\_abstract\AbstractCommand;
use Aws\S3\S3Client;

/**
 *  Command to deploy staging archive
 */
class DeployStagingArchiveCommand extends AbstractCommand
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
        $file = realpath(FILES_ROOT . '/release/release.tar.gz');
        if (file_exists($file) === false) {
            throw new FileException(
                'Unable to find release archive {file}',
                [
                    'file' => $file
                ]
            );
        }

        $awsClient = App::getInstance()
            ->getConfig()
            ->getValue(['aws', 'client']);
        $bucket = App::getInstance()
            ->getConfig()
            ->getValue(['aws', 's3', 'buckets', 'release']);

        try {
            $s3Client = new S3Client(
                [
                    'profile' => $awsClient['profile'],
                    'region'  => $awsClient['region'],
                    'version' => $awsClient['version'],
                ]
            );

            $s3Client->putObject(
                [
                    'Bucket'     => $bucket,
                    'Key'        => 'staging.tar.gz',
                    'SourceFile' => $file,
                ]
            );
        } catch (\Exception $e) {
            throw new FileException($e->getMessage());
        }
    }
}
