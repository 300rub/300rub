<?php

namespace ss\models\blocks\record;

use ss\models\blocks\record\_content\AbstractContentRecordModel;

/**
 * Model for working with table "records"
 */
class RecordModel extends AbstractContentRecordModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordModel';

    /**
     * Gets RecordModel
     *
     * @return RecordModel
     */
    public static function model()
    {
        return new self;
    }
}
