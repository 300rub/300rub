<?php

namespace ss\models\blocks\search\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "search"
 */
abstract class AbstractSearchModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'search';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'formId'      => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\helpers\\form\\FormModel'
            ],
            'searchDesignId'          => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\search\\DesignSearchModel'
            ],
        ];
    }
}
