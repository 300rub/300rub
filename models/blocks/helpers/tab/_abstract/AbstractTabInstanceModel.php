<?php

namespace testS\models\blocks\helpers\tab\_abstract;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "tabInstances"
 */
abstract class AbstractTabInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'tabInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'tabGroupId'     => [
                self::FIELD_RELATION_TO_PARENT => 'TabGroupModel',
            ],
            'textInstanceId' => [
                self::FIELD_RELATION => 'TextInstanceModel',
            ],
            'tabTemplateId'  => [
                self::FIELD_RELATION_TO_PARENT => 'TabTemplateModel',
            ],
        ];
    }
}
