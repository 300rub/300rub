<?php

namespace ss\models\blocks\helpers\tab\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "tabGroups"
 */
abstract class AbstractTabGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'tabGroups';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'tabId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\tab\\TabModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }
}
