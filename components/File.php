<?php

namespace components;

use applications\App;
use components\exceptions\FileException;

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
     * @throws FileException
     */
    public function upload($name)
    {
        if (empty($_FILES[$name]['tmp_name'])) {
            throw new FileException(
                "File with name: {name} was not found in tmp",
                [
                    "name" => $name
                ]
            );
        }

        if (!move_uploaded_file($_FILES[$name]['tmp_name'], $this->_getFullFilePath())) {
            throw new FileException(
                "File with name: {name} was not moved to upload folder",
                [
                    "name" => $name
                ]
            );
        }

        return $this->_getFullFilePath();
    }

    /**
     * Deletes file
     *
     * @throws FileException
     */
    public function delete()
    {
        $fileUploadPath = $this->_getFullFilePath();

        if (
            file_exists($fileUploadPath)
            && unlink($fileUploadPath) === false
        ) {
            throw new FileException(
                "Unable to delete file with path: {path} from upload folder",
                [
                    "path" => $fileUploadPath
                ]
            );
        }

        if (!App::web()->config->isDebug) {
            $ssh = new Ssh();
            $ssh->deleteFile($this->_getFilePath());
        }
    }

    /**
     * Sends file to remote server
     *
     * @throws FileException
     */
    public function send()
    {
        $fileUploadPath = $this->_getFullFilePath();

        if (!file_exists($fileUploadPath)) {
            throw new FileException(
                "File with path: {path} doesn't exist",
                [
                    "path" => $fileUploadPath
                ]
            );
        }

        if (!App::web()->config->isDebug) {
            $ssh = new Ssh();
            $ssh->sendFile($fileUploadPath, $this->_getFilePath());

            if (unlink($fileUploadPath) === false) {
                throw new FileException(
                    "Unable to delete file with path: {path} from upload folder",
                    [
                        "path" => $fileUploadPath
                    ]
                );
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