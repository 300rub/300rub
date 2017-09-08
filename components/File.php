<?php

namespace testS\components;

use testS\components\exceptions\FileException;

/**
 * Class to work with files
 *
 * @package testS\components
 */
class File
{

    /**
     * Default HTTP file name
     */
    const DEFAULT_POST_FILE_NAME = "file";

    /**
     * The original name of the file on the client machine
     *
     * @var string
     */
    private $_name = "";

    /**
     * The mime type of the file, if the browser provided this information.
     * An example would be "image/gif".
     * This mime type is however not checked on the PHP side and therefore don't take its value for granted.
     *
     * @var string
     */
    private $_type = "";

    /**
     * The size, in bytes, of the uploaded file.
     *
     * @var int
     */
    private $_size = 0;

    /**
     * The temporary filename of the file in which the uploaded file was stored on the server.
     *
     * @var string
     */
    private $_tmpName = "";

    /**
     * Generated unique name
     *
     * @var string
     */
    private $_uniqueName = "";

    /**
     * Gets file URL
     *
     * @param string $uniqueName
     *
     * @return string
     */
    public static function getUrl($uniqueName)
    {
        return $uniqueName;
    }

    /**
     * Constructor
     *
     * @param string $postFileName
     */
    public function __construct()
    {
        $this->_setUniqueName();
    }

    /**
     * Sets file info
     *
     * @param string $postFileName
     *
     * @return File
     *
     * @throws FileException
     */
    public function setFileInfo($postFileName = self::DEFAULT_POST_FILE_NAME)
    {
        if (!array_key_exists($postFileName, $_FILES)) {
            throw new FileException(
                "Unable to find the file with POST name: {name} in files: {files}",
                [
                    "name"  => $postFileName,
                    "files" => json_encode($_FILES)
                ]
            );
        }

        $file = $_FILES[$postFileName];

        if (array_key_exists("name", $file)) {
            $this->_name = $file["name"];
        }

        if (array_key_exists("type", $file)) {
            $this->_type = $file["type"];
        }

        if (array_key_exists("size", $file)) {
            $this->_size = $file["size"];
        }

        if (array_key_exists("tmp_name", $file)) {
            $this->_tmpName = $file["tmp_name"];
        }

        return $this;
    }

    /**
     * Generates unique file name
     *
     * @param string $uniqueName
     *
     * @return File
     */
    public function setUniqueName($uniqueName = null)
    {
        if ($uniqueName !== null) {
            $this->_uniqueName = $uniqueName;
            return $this;
        }

        $this->_uniqueName = substr(md5(uniqid() . rand(1, 999)), 0, 10);

        $extension = trim(pathinfo($this->_name, PATHINFO_EXTENSION));
        if ($extension !== "") {
            $this->_uniqueName .= "." . $extension;
        }

        return $this;
    }

//    /**
//     * Uploads the file
//     *
//     * @return File
//     */
//    public function uploadFile()
//    {
//        if (APP_ENV === ENV_DEV) {
//            $this->_localUpload();
//        } else {
//            $this->_externalUpload();
//        }
//
//        return $this;
//    }
//
//    /**
//     * Uploads the file locally
//     *
//     * DEV only
//     */
//    protected function _localUpload()
//    {
//        $this->generateUniqueName();
//
//        $uploadDir = "/var/www/public/upload";
//        $path = $uploadDir . "/" . $this->generatedName;
//
//        move_uploaded_file($this->tmpName, $path);
//        chmod($path, 0777);
//    }
//
//    /**
//     * Uploads the file to external service
//     *
//     * PROD and PIT
//     */
//    protected function _externalUpload()
//    {
//        // @TODO Amazon S3 for example
//    }

}
