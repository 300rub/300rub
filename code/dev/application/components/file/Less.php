<?php

namespace ss\application\components\file;

/**
 * Class for working with less files
 */
class Less
{

    const TYPE_COMMON = "common";
    const TYPE_ADMIN = "admin";

    private $_dirList = [];

    private $_parentMap = [];

    private $_filesContent = [];

    private $_lessContent = '';

    public function __construct($type)
    {
        switch ($type) {
            case self::TYPE_ADMIN:
                $this->_dirList = ['common', 'admin'];
                break;
            default:
                $this->_dirList = ['common'];
                break;
        }
    }

    public function getCss()
    {
        $less = new \lessc;
        return $less->compile($this->_getContent());
    }

    private function _getContent()
    {
        $this->_setContent();

        return $this->_lessContent;
    }

    private function _setContent()
    {
        $this->_parseFiles();

        foreach (array_keys($this->_parentMap) as $file) {
            $this->_addContent($file);
        }
    }

    private function _parseFiles()
    {
        foreach ($this->_dirList as $dirName) {
            $directory = new \RecursiveDirectoryIterator(
                $this->_getDirPath($dirName)
            );
            $iterator = new \RecursiveIteratorIterator($directory);

            foreach ($iterator as $file) {
                $this->_parseFile($file);
            }
        }

        return $this;
    }

    private function _addContent($file)
    {
        foreach ($this->_parentMap[$file] as $parent) {
            $this->_addContent($parent);
        }

        if (array_key_exists($file, $this->_filesContent) === false) {
            return $this;
        }

        $this->_lessContent .= $this->_filesContent[$file];
        unset($this->_filesContent[$file]);

        return $this;
    }

    /**
     * Parses file
     *
     * @param \SplFileInfo $file
     *
     * @return Less
     */
    private function _parseFile($file)
    {
        $path = realpath($file->getPathname());

        if (strpos($path, '.less') === false
            || $path === false
        ) {
            return $this;
        }

        $this->_parentMap[$path] = [];
        $content = file_get_contents($path);

        preg_match_all('/\@import\s\"[a-zA-Z0-9\.\/_-]+\"\;/', $content, $matches);

        if (count($matches[0]) > 0) {
            foreach ($matches[0] as $match) {
                $parent = realpath(
                    sprintf(
                        '%s/%s.less',
                        dirname($path),
                        str_replace(['@import "', '";', '.less'], '', $match)
                    )
                );

                if ($parent !== false) {
                    $this->_parentMap[$path][] = $parent;
                }
            }

            $content = str_replace($matches[0], '', $content);
        }

        $this->_filesContent[$path] = $content;

        return $this;
    }

    private function _getDirPath($dirName)
    {
        return __DIR__ . '/../../../public/static/' . $dirName;
    }
}
