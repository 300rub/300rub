<?php

namespace testS\models\blocks\search\_base;

use testS\models\blocks\search\_abstract\AbstractSearchModel as Model;

/**
 * Abstract model for working with table "search"
 */
abstract class AbstractSearchModel extends Model
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
                    => '\\testS\\models\\blocks\\helpers\\form\\FormModel'
            ],
            'searchDesignId'          => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\search\\DesignSearchModel'
            ],
        ];
    }
}
