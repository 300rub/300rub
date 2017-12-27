<?php

namespace testS\models\blocks\helpers\tab\_base;

use testS\models\blocks\helpers\tab\_abstract\AbstractTabModel;

/**
 * Abstract model for working with table "tabGroups"
 */
abstract class AbstractTabGroupModel extends AbstractTabModel
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
                    => '\\testS\\models\\blocks\\helpers\\tab\\TabModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }
}
