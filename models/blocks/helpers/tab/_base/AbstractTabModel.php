<?php

namespace ss\models\blocks\helpers\tab\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "tabs"
 */
abstract class AbstractTabModel extends AbstractModel
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
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\helpers\\tab\\DesignTabModel'
            ],
            'textId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\TextModel'
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
