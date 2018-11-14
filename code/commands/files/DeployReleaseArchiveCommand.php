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
     * How many releases to keep
     */
    const LIMIT = 5;

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

        $key = $this->getArg(0);

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
                    'Key'        => $key,
                    'SourceFile' => $file,
                ]
            );

            $listObjects = $s3Client->listObjects(
                [
                    'Bucket' => $bucket
                ]
            );

            $contents = $listObjects->get('Contents');

            $releases = [];
            foreach ($contents as $content) {
                $releases[] = (int)$content['Key'];
            }

            rsort($releases);
            $number = 0;
            foreach ($releases as $release) {
                $number++;

                if ($number <= self::LIMIT) {
                    continue;
                }

                $s3Client->deleteObject(
                    [
                        'Bucket' => $bucket,
                        'Key'    => $release,
                    ]
                );
            }
        } catch (\Exception $e) {
            throw new FileException($e->getMessage());
        }
    }
}
