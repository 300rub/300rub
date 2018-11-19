<?php

namespace ss\models\blocks\helpers\file;

use ss\models\blocks\helpers\file\_base\AbstractRemovedFileModel;

/**
 * Model for working with table "removedFiles"
 */
class RemovedFileModel extends AbstractRemovedFileModel
{

    /**
     * Gets model
     *
     * @return RemovedFileModel
     */
    public static function model()
    {
        return new self;
    }
}
