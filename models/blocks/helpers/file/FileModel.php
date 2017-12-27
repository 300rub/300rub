<?php

namespace testS\models\blocks\helpers\file;

use testS\application\App;
use testS\application\exceptions\FileException;
use testS\models\blocks\helpers\file\_base\AbstractFileModel;

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
        if (APP_ENV !== ENV_DEV) {
            return '';
        }

        return sprintf(
            App::getInstance()->getConfig()->getValue(['file', 'urlMask']),
            trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'")),
            App::getInstance()->getSite()->getId(),
            $this->get('uniqueName')
        );
    }

    /**
     * Uploads a file
     *
     * @return FileModel
     */
    public function upload()
    {
        if (APP_ENV === ENV_DEV) {
            $this->_localUpload();
        }

        return $this;
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
     * Uploads a file locally
     *
     * @throws FileException
     *
     * @return void
     */
    private function _localUpload()
    {
        if (file_exists($this->_tmpName) === false) {
            throw new FileException(
                'Unable to find tmp file with name: {name}',
                [
                    'name' => $this->_tmpName
                ]
            );
        }

        $path = sprintf(
            App::getInstance()
                ->getConfig()
                ->getValue(['file', 'pathMask']),
            App::getInstance()->getSite()->getId(),
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
     * Deletes file by unique name
     *
     * @param string $name Unique name
     *
     * @return void
     */
    public function deleteByUniqueName($name)
    {
        if (APP_ENV === ENV_DEV) {
            self::_localDeleteByUniqueName($name);
        }
    }

    /**
     * Deletes file by unique name locally
     *
     * @param string $name Unique name
     *
     * @throws FileException
     *
     * @return void
     */
    private function _localDeleteByUniqueName($name)
    {
        $path = sprintf(
            App::getInstance()
                ->getConfig()
                ->getValue(['file', 'pathMask']),
            App::getInstance()->getSite()->getId(),
            $name
        );

        if (file_exists($path) === true
            && unlink($path) === false
        ) {
            throw new FileException(
                'Unable to remove file by unique name: {name}',
                [
                    'name' => $name,
                ]
            );
        }
    }
}
