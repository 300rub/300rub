<?php

namespace ss\commands\files;

use ss\application\App;
use ss\application\exceptions\FileException;
use ss\commands\_abstract\AbstractCommand;
use Aws\S3\S3Client;

/**
 *  Command to deploy release archive
 */
class DeployReleaseArchiveCommand extends AbstractCommand
{

    /**
     * Runs the command
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

        $key = $this->getArg(0);

        try {
            $s3Client = new S3Client([
                'profile' => $awsClient['profile'],
                'region'  => $awsClient['region'],
                'version' => $awsClient['version'],
            ]);

            $result = $s3Client->putObject([
                'Bucket'     => $bucket,
                'Key'        => $key,
                'SourceFile' => $file,
            ]);
            var_dump($result);

            $result = $s3Client->listObjects([
                'Bucket' => $bucket
            ]);
            var_dump($result);
        } catch (\Exception $e) {
            throw new FileException($e->getMessage());
        }
    }
}
