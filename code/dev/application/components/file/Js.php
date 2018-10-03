<?php

namespace ss\application\components\file;

use ss\application\components\file\_abstract\AbstractFile;

/**
 * Class for working with js files
 */
class Js extends AbstractFile
{

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

        return $list;
    }
}
