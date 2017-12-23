<?php

namespace testS\models\blocks\helpers\tab\_abstract;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "tabs"
 */
class AbstractTabModel extends AbstractModel
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
