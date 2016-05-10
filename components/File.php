<?php

namespace components;
use application\App;

/**
 * Class for working with files
 *
 * @package components
 */
class File
{

    /**
     * File name
     *
     * @var string
     */
    private $_name = "";

    /**
     * File constructor.
     *
     * @param string $name File's name
     */
    public function __construct($name)
    {
        $this->_name = $name;
    }

    /**
     * Uploads file
     *
     * @param string $name File's name
     *
     * @return string
     *
     * @throws Exception
     */
    public function upload($name)
    {
        if (empty($_FILES[$name]['tmp_name'])) {
            throw new Exception("File was not found in tmp");
        }

        if (!move_uploaded_file($_FILES[$name]['tmp_name'], $this->_getFullFilePath())) {
            throw new Exception("File was not moved to upload folder");
        }

        return $this->_getFullFilePath();
    }

    /**
     * Deletes file
     *
     * @throws Exception
     */
    public function delete()
    {
        $fileUploadPath = $this->_getFullFilePath();

        if (
            file_exists($fileUploadPath)
            && unlink($fileUploadPath) === false
        ) {
            throw new Exception("Unable to delete file from upload folder");
        }

        if (!App::web()->config->isDebug) {
            $ssh = new Ssh();
            if ($ssh->deleteFile($this->_getFilePath())) {
                throw new Exception("Unable to delete file from remote server");
            }
        }
    }

    /**
     * Sends file to remote server
     *
     * @throws Exception
     */
    public function send()
    {
        $fileUploadPath = $this->_getFullFilePath();

        if (!file_exists($fileUploadPath)) {
            throw new Exception("File doesn't exist");
        }

        if (!App::web()->config->isDebug) {
            $ssh = new Ssh();
            if ($ssh->sendFile($fileUploadPath, $this->_getFilePath())) {
                throw new Exception("Unable to send file to remote server");
            }

            if (unlink($fileUploadPath) === false) {
                throw new Exception("Unable to delete file from upload folder");
            }
        }
    }

    /**
     * Gets file path
     *
     * @return string
     */
    private function _getFilePath()
    {
        return App::web()->config->siteId . "/" . $this->_name;
    }

    /**
     * Gets file path in upload folder
     *
     * @return string
     */
    private function _getFullFilePath()
    {
        return __DIR__ . "/../public/upload/" . $this->_getFilePath();
    }
}