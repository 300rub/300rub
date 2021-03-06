<?php

namespace ss\application\components\file\_abstract;

/**
 * Class for working with less files
 */
abstract class AbstractFile
{

    /**
     * Types
     */
    const TYPE_COMMON = 'common';
    const TYPE_ADMIN = 'admin';
    const TYPE_SITE = 'site';

    /**
     * File extension
     */
    const EXTENSION = '';

    /**
     * Type
     *
     * @var string
     */
    private $_type = self::TYPE_COMMON;

    /**
     * Dir list
     *
     * @var string[]
     */
    private $_dirList = [];

    /**
     * Version
     *
     * @var integer
     */
    private $_version = 0;

    /**
     * Minimized flag
     *
     * @var boolean
     */
    private $_hasMinimized = true;

    /**
     * Less constructor.
     *
     * @param string $type Type
     */
    public function __construct($type)
    {
        switch ($type) {
            case self::TYPE_ADMIN:
                $this->_dirList = [self::TYPE_COMMON, self::TYPE_ADMIN];
                $this->_type = $type;
                break;
            case self::TYPE_SITE:
                $this->_dirList = [self::TYPE_COMMON, self::TYPE_SITE];
                $this->_type = $type;
                break;
            default:
                $this->_dirList = [self::TYPE_COMMON];
                $this->_type = self::TYPE_COMMON;
                break;
        }
    }

    /**
     * Gets dir list
     *
     * @return string[]
     */
    protected function getDirList()
    {
        return $this->_dirList;
    }

    /**
     * Gets dir name
     *
     * @param string $dirName Dir name
     *
     * @return string
     */
    protected function getDirPath($dirName)
    {
        return sprintf(
            '%s/static/%s',
            $this->getPublicPath(),
            $dirName
        );
    }

    /**
     * Gets public path
     *
     * @return string
     */
    protected function getPublicPath()
    {
        return __DIR__ . '/../../../../public';
    }

    /**
     * Sets version
     *
     * @param int $version Version
     *
     * @return AbstractFile
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    /**
     * Gets version
     *
     * @return int
     */
    protected function getVersion()
    {
        return $this->_version;
    }

    /**
     * Sets has minimized flag
     *
     * @param bool $hasMinimized Minimized flag
     *
     * @return AbstractFile
     */
    public function setHasMinimized($hasMinimized)
    {
        $this->_hasMinimized = $hasMinimized;
        return $this;
    }

    /**
     * Gets minimized flag
     *
     * @return bool
     */
    protected function hasMinimized()
    {
        return $this->_hasMinimized;
    }

    /**
     * Gets minimized URI
     *
     * @return string
     */
    protected function getMinimizedUri()
    {
        return sprintf(
            '/static/min/%s.min.%s?%s',
            $this->_type,
            static::EXTENSION,
            $this->_version
        );
    }

    /**
     * Gets minimized Path
     *
     * @return string
     */
    public function getMinimizedPath()
    {
        return sprintf(
            '%s/../../../../public/static/min/%s.min.%s',
            __DIR__,
            $this->_type,
            static::EXTENSION
        );
    }

    /**
     * Gets map
     *
     * @return array
     */
    protected function getMap()
    {
        return include __DIR__ . '/../../../../config/other/staticVendor.php';
    }
}
