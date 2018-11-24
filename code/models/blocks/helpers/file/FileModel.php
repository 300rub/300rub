<?php

namespace ss\models\blocks\helpers\file;

use Aws\S3\S3Client;
use ss\application\App;
use ss\application\exceptions\FileException;
use ss\models\blocks\helpers\file\_base\AbstractFileModel;

/**
 * Model for working with table "files"
 */
class FileModel extends AbstractFileModel
{

    /**
     * HTTP file name
     */
    const POST_FILE_NAME = 'file';

    /**
     * The temporary filename of the file
     * in which the uploaded file was stored on the server.
     *
     * @var string
     */
    private $_tmpName = '';

    /**
     * Generates unique hash
     *
     * @return string
     */
    private static function _generateUniqueHash()
    {
        return substr(md5(uniqid() . rand(1, 999)), 0, 10);
    }

    /**
     * Gets file URL
     *
     * @return string
     */
    public function getUrl()
    {
        if (APP_ENV === ENV_DEV) {
            return $this->_getDevUrl();
        }

        return $this->_getProdUrl();
    }

    /**
     * Gets dev URL
     *
     * @return string
     */
    private function _getDevUrl()
    {
        return sprintf(
            App::getInstance()->getConfig()->getValue(['file', 'urlMask']),
            'http',
            App::getInstance()
                ->getSuperGlobalVariable()
                ->getServerValue('HTTP_HOST'),
            App::getInstance()->getSite()->get('name'),
            $this->get('uniqueName')
        );
    }

    /**
     * Gets prod URL
     *
     * @return string
     */
    private function _getProdUrl()
    {
        $method = 'http';
        $isHttps = App::getInstance()
            ->getSuperGlobalVariable()
            ->isHttps();
        if ($isHttps === true) {
            $method = 'https';
        }

        return sprintf(
            App::getInstance()->getConfig()->getValue(['file', 'urlMask']),
            $method,
            App::getInstance()->getSite()->getId(),
            $this->get('uniqueName')
        );
    }

    /**
     * Parses POST request
     *
     * @return FileModel
     *
     * @throws FileException
     */
    public function parsePostRequest()
    {
        $file = App::getInstance()
            ->getSuperGlobalVariable()
            ->getFilesValue(self::POST_FILE_NAME);

        if ($file === null) {
            throw new FileException(
                'Unable to find the file with ' .
                'POST name: {name} in files: {files}',
                [
                    'name'  => self::POST_FILE_NAME,
                    'files' => json_encode(
                        App::getInstance()
                            ->getSuperGlobalVariable()
                            ->getFilesValue()
                    )
                ]
            );
        }

        if (array_key_exists('name', $file) === true) {
            $this->set(['originalName' => $file['name']]);
        }

        if (array_key_exists('type', $file) === true) {
            $this->set(['type' => $file['type']]);
        }

        if (array_key_exists('size', $file) === true) {
            $this->set(['size' => $file['size']]);
        }

        if (array_key_exists('tmp_name', $file) === true) {
            $this->_tmpName = $file['tmp_name'];
        }

        return $this;
    }

    /**
     * Generates tmp name
     *
     * @return FileModel
     */
    public function generateTmpName()
    {
        $this->_tmpName = sprintf(
            '/tmp/%s_%s',
            date('Y-m-d'),
            self::_generateUniqueHash()
        );

        return $this;
    }

    /**
     * Gets tmp name
     *
     * @return string
     */
    public function getTmpName()
    {
        return $this->_tmpName;
    }

    /**
     * Sets file size from tmp file
     *
     * @return FileModel
     */
    public function setSizeFromTmpFile()
    {
        $this->set(['size' => filesize($this->_tmpName)]);
        return $this;
    }

    /**
     * Ses unique file name
     *
     * @param string $extension File extension
     *
     * @return FileModel
     */
    public function setUniqueName($extension = '')
    {
        $uniqueName = self::_generateUniqueHash();

        if ($extension === '') {
            $extension = trim(
                strtolower(
                    pathinfo(
                        $this->get('originalName'),
                        PATHINFO_EXTENSION
                    )
                )
            );
        }

        if ($extension !== '') {
            $uniqueName .= '.' . $extension;
        }

        $this->set(['uniqueName' => $uniqueName]);

        return $this;
    }

    /**
     * Uploads a file
     *
     * @return FileModel
     *
     * @throws FileException
     */
    public function upload()
    {
        if (file_exists($this->_tmpName) === false) {
            throw new FileException(
                'Unable to find tmp file with name: {name}',
                [
                    'name' => $this->_tmpName
                ]
            );
        }

        if (APP_ENV === ENV_DEV) {
            $this->_devUpload();
            return $this;
        }

        $this->_prodUpload();
        return $this;
    }

    /**
     * Uploads a file locally
     *
     * @throws FileException
     *
     * @return void
     */
    private function _devUpload()
    {
        $path = sprintf(
            App::getInstance()
                ->getConfig()
                ->getValue(['file', 'pathMask']),
            App::getInstance()->getSite()->get('name'),
            $this->get('uniqueName')
        );

        if (copy($this->_tmpName, $path) === false) {
            if (unlink($this->_tmpName) === false) {
                throw new FileException(
                    'Unable to copy and remove uploaded file ' .
                    'with tmpName: {tmpName}',
                    [
                        'tmpName' => $this->_tmpName,
                    ]
                );
            }

            throw new FileException(
                'Unable to copy uploaded file. ' .
                'Name: {name}, type: {type}, size: {size}, ' .
                'tmpName: {tmpName}, uniqueName: {uniqueName}',
                [
                    'name'       => $this->get('originalName'),
                    'type'       => $this->get('type'),
                    'size'       => $this->get('size'),
                    'tmpName'    => $this->_tmpName,
                    'uniqueName' => $this->get('uniqueName'),
                ]
            );
        }

        if (unlink($this->_tmpName) === false) {
            throw new FileException(
                'Unable to remove uploaded file with tmpName: {tmpName}',
                [
                    'tmpName' => $this->_tmpName,
                ]
            );
        }

        chmod($path, 0777);
    }

    /**
     * Uploads a file to S3
     *
     * @return void
     *
     * @throws FileException
     */
    private function _prodUpload()
    {
        try {
            $bucket = App::getInstance()
                ->getConfig()
                ->getValue(['aws', 's3', 'buckets', 'main']);

            $key = sprintf(
                '%s/%s',
                App::getInstance()->getSite()->getId(),
                $this->get('uniqueName')
            );

            $s3Credentials = App::getInstance()
                ->getConfig()
                ->getValue(['aws', 's3', 'credentials']);

            $s3Client = new S3Client(
                [
                    'key'    => $s3Credentials['accessKeyId'],
                    'secret' => $s3Credentials['secretAccessKey'],
                ]
            );

            $s3Client->putObject(
                [
                    'Bucket'     => $bucket,
                    'Key'        => $key,
                    'SourceFile' => $this->_tmpName,
                ]
            );
        } catch (\Exception $e) {
            throw new FileException($e->getMessage());
        }
    }

    /**
     * Deletes file by unique name
     *
     * @param string $uniqueName Unique name
     *
     * @return FileModel
     */
    public function deleteByUniqueName($uniqueName)
    {
        RemovedFileModel::model()
            ->set(['uniqueName' => $uniqueName])
            ->save();

        return $this;
    }

    /**
     * Runs after deleting
     *
     * @return void
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        try {
            $this->deleteByUniqueName($this->get('uniqueName'));
        } catch (\Exception $e) {
            App::getInstance()->getLogger()->error(
                'Unable to remove file by unique name: {name}',
                [
                    'name' => $this->get('uniqueName')
                ],
                'file'
            );
        }
    }
}
