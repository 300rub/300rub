<?php

namespace ss\application\components\file;

use ss\application\components\file\_abstract\AbstractFile;

/**
 * Class for working with css files
 */
class Css extends AbstractFile
{

    /**
     * File extension
     */
    const EXTENSION = 'css';

    /**
     * Gets css list
     *
     * @return string[]
     */
    public function getCssList()
    {
        $map = $this->getMap();

        $list = [];

        $dirPath = $this->getDirPath('fonts');
        $publicPath = $this->getPublicPath();

        $directory = new \RecursiveDirectoryIterator($dirPath);
        $iterator = new \RecursiveIteratorIterator($directory);
        foreach ($iterator as $file) {
            $path = realpath($file->getPathname());

            if (strpos($path, '.css') === false
                || $path === false
            ) {
                continue;
            }

            $filePath = str_replace(realpath($publicPath), '', $path);
            $list[] = $filePath;
        }

        foreach ($this->getDirList() as $dir) {
            foreach (array_keys($map[$dir]['css']) as $file) {
                $list[] = sprintf(
                    '/static/%s/lib/%s?%s',
                    $dir,
                    $file,
                    $this->getVersion()
                );
            }
        }

        if ($this->hasMinimized() === true) {
            $list[] = $this->getMinimizedUri();
        }

        return $list;
    }
}
