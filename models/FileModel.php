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
     * Generates unique hash
     *
     * @return string
     */
    private static function _generateUniqueHash()
    {
        return substr(md5(uniqid() . rand(1, 999)), 0, 10);
    }

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
                trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'")),
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
        if (APP_ENV === ENV_DEV) {
            $this->_localUpload();
        } else {

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
     * Generates tmp name
     *
     * @return FileModel
     */
    public function generateTmpName()
    {
        $this->_tmpName = "/tmp/" . self::_generateUniqueHash();
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
        $this->set(["size" => filesize($this->_tmpName)]);
        return $this;
    }

    /**
     * Ses unique file name
     *
     * @param string $extension
     *
     * @return FileModel
     */
    public function setUniqueName($extension = "")
    {
        if ($this->get("uniqueName") !== "") {
            return $this;
        }

        $uniqueName = self::_generateUniqueHash();

        if ($extension === "") {
            $extension = trim(strtolower(pathinfo($this->get("originalName"), PATHINFO_EXTENSION)));
        }

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

        if (!copy($this->_tmpName, $path)) {
            if (!unlink($this->_tmpName)) {
                throw new FileException(
                    "Unable to copy and remove uploaded file with tmpName: {tmpName}",
                    [
                        "tmpName" => $this->_tmpName,
                    ]
                );
            }

            throw new FileException(
                "Unable to copy uploaded file. " .
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

        if (!unlink($this->_tmpName)) {
            throw new FileException(
                "Unable to remove uploaded file with tmpName: {tmpName}",
                [
                    "tmpName" => $this->_tmpName,
                ]
            );
        }

        chmod($path, 0777);
    }
}