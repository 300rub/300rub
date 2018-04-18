<?php

namespace ss\models\blocks\record;

use ss\models\blocks\record\_base\AbstractRecordModel;

/**
 * Model for working with table "records"
 */
class RecordModel extends AbstractRecordModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordModel';

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        return '1111111111';
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        return [];
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
    }

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
