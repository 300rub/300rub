<?php

namespace testS\models;

use testS\applications\App;
use testS\components\exceptions\FileException;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "files"
 *
 * @package testS\models
 */
class FileModel extends AbstractModel
{

    /**
     * HTTP file name
     */
    const POST_FILE_NAME = "file";

    /**
     * The temporary filename of the file in which the uploaded file was stored on the server.
     *
     * @var string
     */
    private $_tmpName = "";

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "files";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "originalName" => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "type"         => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 50,
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "size"         => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "uniqueName"   => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 25,
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "isRemoved"    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }

    /**
     * Gets file URL
     *
     * @return string
     */
    public function getUrl()
    {
        $app = App::getInstance();
        $siteId = $app->getSite()->getId();

        if (APP_ENV === ENV_DEV) {
            return sprintf(
                $app->getConfig(["file", "urlMask"]),
                $siteId,
                $this->get("uniqueName")
            );
        } else {
            return "";
        }
    }

    /**
     * Uploads a file
     *
     * @return FileModel
     */
    public function upload()
    {
        $this
            ->_setFileInfo()
            ->_setUniqueName();

        if (APP_ENV === ENV_DEV) {
            $this->_localUpload();
        } else {

        }

        return $this;
    }

    /**
     * Sets file info
     *
     * @return FileModel
     *
     * @throws FileException
     */
    private function _setFileInfo()
    {
        if (!array_key_exists(self::POST_FILE_NAME, $_FILES)) {
            throw new FileException(
                "Unable to find the file with POST name: {name} in files: {files}",
                [
                    "name"  => self::POST_FILE_NAME,
                    "files" => json_encode($_FILES)
                ]
            );
        }

        $file = $_FILES[self::POST_FILE_NAME];

        if (array_key_exists("name", $file)) {
            $this->set(["originalName" => $file["name"]]);
        }

        if (array_key_exists("type", $file)) {
            $this->set(["type" => $file["type"]]);
        }

        if (array_key_exists("size", $file)) {
            $this->set(["size" => $file["size"]]);
        }

        if (array_key_exists("tmp_name", $file)) {
            $this->_tmpName = $file["tmp_name"];
        }

        return $this;
    }

    /**
     * Ses unique file name
     *
     * @return FileModel
     */
    private function _setUniqueName()
    {
        if ($this->get("uniqueName") !== "") {
            return $this;
        }

        $uniqueName = substr(md5(uniqid() . rand(1, 999)), 0, 10);

        $extension = trim(pathinfo($this->get("originalName"), PATHINFO_EXTENSION));
        if ($extension !== "") {
            $uniqueName .= "." . $extension;
        }

        $this->set(["uniqueName" => $uniqueName]);

        return $this;
    }

    /**
     * Uploads a file locally
     *
     * @throws FileException
     */
    private function _localUpload()
    {
        if (!file_exists($this->_tmpName)) {
            throw new FileException(
                "Unable to find tmp file with name: {name}",
                [
                    "name" => $this->_tmpName
                ]
            );
        }

        $app = App::getInstance();
        $path = sprintf(
            $app->getConfig(["file", "pathMask"]),
            $app->getSite()->getId(),
            $this->get("uniqueName")
        );

        if (!move_uploaded_file($this->_tmpName, $path)) {
            throw new FileException(
                "Unable to move uploaded file. " .
                "Name: {name}, type: {type}, size: {size}, tmpName: {tmpName}, uniqueName: {uniqueName}",
                [
                    "name"       => $this->get("originalName"),
                    "type"       => $this->get("type"),
                    "size"       => $this->get("size"),
                    "tmpName"    => $this->_tmpName,
                    "uniqueName" => $this->get("uniqueName"),
                ]
            );
        }

        chmod($path, 0777);
    }
}