<?php

namespace testS\models\blocks\helpers\tab\_base;

use testS\models\blocks\helpers\tab\_abstract\AbstractTabModel as Model;

/**
 * Abstract model for working with table "tabs"
 */
abstract class AbstractTabModel extends Model
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'tabs';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'designTabsId'       => [
                self::FIELD_RELATION => 'DesignTabModel'
            ],
            'textId'       => [
                self::FIELD_RELATION => 'TextModel'
            ],
            'isShowEmpty'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'isLazyLoad'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}
