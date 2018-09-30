<?php

namespace ss\application\components\file;

use ss\application\components\file\_abstract\AbstractFile;

/**
 * Class for working with css files
 */
class Css extends AbstractFile
{

    /**
     * Gets css list
     *
     * @return string[]
     */
    public function getCssList()
    {
        $map = include CODE_ROOT . "/config/other/staticVendor.php";

        $list = [];

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
            $list[] = $this->getMinimizedUri('css');
        }

        return $list;
    }
}
