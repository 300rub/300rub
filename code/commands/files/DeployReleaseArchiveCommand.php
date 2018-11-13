<?php

namespace ss\commands\files;

use Aws\S3\Exception\S3Exception;
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
        // Credentials
        //https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials_profiles.html

        //https://github.com/awsdocs/aws-doc-sdk-examples/tree/master/php/example_code/s3

        $file = CODE_ROOT . '/release/release.tar.gz';
        if (file_exists($file) === false) {
            throw new FileException('Unable to find release archive.');
        }

        $awsClient = App::getInstance()
            ->getConfig()
            ->getValue(['aws', 'client']);
        $bucket = App::getInstance()
            ->getConfig()
            ->getValue(['aws', 's3', 'buckets', 'release']);

        $key = 'release-x';

        try {
            $s3Client = new S3Client([
                'profile' => $awsClient['profile'],
                'region'  => $awsClient['region'],
                'version' => $awsClient['version'],
            ]);

            $s3Client->putObject([
                'Bucket'     => $bucket,
                'Key'        => $key,
                'SourceFile' => $file,
            ]);
        } catch (\Exception $e) {
            throw new FileException($e->getMessage());
        }
    }
}
