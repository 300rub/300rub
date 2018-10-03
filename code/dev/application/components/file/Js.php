<?php

namespace ss\application\components\file;

use ss\application\components\file\_abstract\AbstractFile;

/**
 * Class for working with js files
 */
class Js extends AbstractFile
{

    /**
     * Main file
     */
    const MAIN_FILE = '/static/common/core/js/ss.js';

    /**
     * Gets css list
     *
     * @return string[]
     */
    public function getJsList()
    {
        $map = $this->getMap();

        $list = [];

        foreach ($this->getDirList() as $dir) {
            foreach (array_keys($map[$dir]['js']) as $file) {
                $list[] = sprintf(
                    '/static/%s/lib/%s?%s',
                    $dir,
                    $file,
                    $this->getVersion()
                );
            }
        }

        if ($this->hasMinimized() === true) {
            $list[] = $this->getMinimizedUri('js');
        }

        if ($this->hasMinimized() === false) {
            $list = array_merge($list, $this->getFileList());
        }

        return $list;
    }

    /**
     * Gets file list
     *
     * @return array
     */
    protected function getFileList()
    {
        $list = [self::MAIN_FILE];
        $publicPath = $this->getPublicPath();

        foreach ($this->getDirList() as $dir) {
            $dirPath = $this->getDirPath($dir);
            $libPath = realpath(sprintf('%s/lib', $dirPath));

            $directory = new \RecursiveDirectoryIterator($dirPath);
            $iterator = new \RecursiveIteratorIterator($directory);

            foreach ($iterator as $file) {
                $path = realpath($file->getPathname());

                if (strpos($path, '.js') === false
                    || strpos($path, $libPath) !== false
                    || $path === false
                ) {
                    continue;
                }

                $filePath = str_replace(realpath($publicPath), '', $path);
                if ($filePath === self::MAIN_FILE) {
                    continue;
                }

                $list[] = $filePath;
            }
        }

        return $list;
    }
}
