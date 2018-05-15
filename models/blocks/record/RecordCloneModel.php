<?php

namespace ss\models\blocks\record;

use ss\models\blocks\record\_base\AbstractRecordCloneModel;

/**
 * Model for working with table "recordClones"
 */
class RecordCloneModel extends AbstractRecordCloneModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordCloneModel';

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        return '';
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
     * Gets new model
     *
     * @return RecordCloneModel
     */
    public static function model()
    {
        return new self;
    }
}
