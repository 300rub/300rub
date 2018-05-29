<?php

namespace ss\models\blocks\record;

use ss\models\blocks\record\_content\AbstractContentRecordCloneModel;

/**
 * Model for working with table "recordClones"
 */
class RecordCloneModel extends AbstractContentRecordCloneModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordCloneModel';

    /**
     * Gets new model
     *
     * @return RecordCloneModel
     */
    public static function model()
    {
        return new self;
    }
}
