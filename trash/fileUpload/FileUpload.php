<?php

/**
 * Class Tocsui_Logic_FileUpload
 */
class Tocsui_Logic_FileUpload
{

    /**
     * HTTP file name
     */
    const FILE_NAME = "file";

    /**
     * @var string
     */
    protected $name = "";

    /**
     * @var string
     */
    protected $type = "";

    /**
     * @var int
     */
    protected $size = 0;

    /**
     * @var string
     */
    protected $tmpName = "";

    /**
     * @var string
     */
    protected $generatedName = "";

    /**
     * @var string
     */
    protected $httpLink = "";

    /**
     * @var Zend_File_Transfer_Adapter_Http
     */
    protected $adapterHttp = null;

    /**
     * Tocsui_Logic_FileUpload constructor.
     *
     * @param Zend_File_Transfer_Adapter_Http $adapterHttp
     *
     * @throws Zend_File_Transfer_Exception
     */
    public function __construct(Zend_File_Transfer_Adapter_Http $adapterHttp)
    {
        $this->adapterHttp = $adapterHttp;

        $files = $this->adapterHttp->getFileInfo();

        if (count($files) !== 1 || empty($files[self::FILE_NAME])) {
            throw new Zend_File_Transfer_Exception("The file has not been uploaded");
        }

        $fileInfo = $files[self::FILE_NAME];

        $this->name = $fileInfo["name"];
        $this->type = $fileInfo["type"];
        $this->size = $fileInfo["size"];
        $this->tmpName = $fileInfo["tmp_name"];
    }

    /**
     * Uploads the file
     *
     * @return Tocsui_Logic_FileUpload
     */
    public function uploadFile()
    {
        if (APPLICATION_ENV === 'development') {
            $this->localUpload();
        } else {
            $this->externalUpload();
        }

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets HTTP link
     *
     * @return string
     */
    public function getHttpLink()
    {
        if (!$this->httpLink) {
            if (APPLICATION_ENV === 'development') {
                $this->setLocalHttpLink();
            } else {
                $this->setExternalHttpLink();
            }
        }

        return $this->httpLink;
    }

    /**
     * Sets local http link
     *
     * DEV only
     */
    protected function setLocalHttpLink()
    {
        $this->httpLink = "/upload/" . $this->generatedName;
    }

    /**
     * Sets external link
     *
     * PROD and PIT
     */
    protected function setExternalHttpLink()
    {
        // @TODO Amazon S3 for example
    }

    /**
     * Uploads the file locally
     *
     * DEV only
     */
    protected function localUpload()
    {
        $this->generateUniqueName();

        $uploadDir = "/var/www/public/upload";
        $path = $uploadDir . "/" . $this->generatedName;

        move_uploaded_file($this->tmpName, $path);
        chmod($path, 0777);
    }

    /**
     * Uploads the file to external service
     *
     * PROD and PIT
     */
    protected function externalUpload()
    {
        // @TODO Amazon S3 for example
    }

    /**
     * Generates unique file name
     *
     * @return Tocsui_Logic_FileUpload
     */
    protected function generateUniqueName()
    {
        if (strpos($this->name, ".") !== false) {
            $explode = explode(".", $this->name);
            $format = $explode[count($explode) - 1];

            $this->generatedName = uniqid() . "." . $format;
        } else {
            $this->generatedName = uniqid();
        }

        return $this;
    }
}
