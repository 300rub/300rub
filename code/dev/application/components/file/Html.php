<?php

namespace ss\application\components\file;

use ss\application\components\file\_abstract\AbstractFile;

/**
 * Class for working with html files
 */
class Html extends AbstractFile
{

    /**
     * Gets css list
     *
     * @return string[]
     */
    public function getHtml()
    {
        if ($this->hasMinimized() === true) {
            return file_get_contents($this->getMinimizedPath('html'));
        }

        $html = '';

        foreach ($this->getDirList() as $dir) {
            $dirPath = $this->getDirPath($dir);
            $libPath = realpath(sprintf('%s/lib', $dirPath));

            $directory = new \RecursiveDirectoryIterator($dirPath);
            $iterator = new \RecursiveIteratorIterator($directory);

            foreach ($iterator as $file) {
                $path = realpath($file->getPathname());

                if (strpos($path, '.html') === false
                    || strpos($path, $libPath) !== false
                    || $path === false
                ) {
                    continue;
                }

                $html .= file_get_contents($path);
            }
        }

        return $html;
    }
}
