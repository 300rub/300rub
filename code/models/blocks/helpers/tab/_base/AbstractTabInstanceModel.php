<?php

namespace ss\models\blocks\helpers\tab\_base;

use ss\models\_abstract\AbstractModel;

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
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\tab\\TabGroupModel',
            ],
            'textInstanceId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\TextInstanceModel',
            ],
            'tabTemplateId'  => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\' .
                        'tab\\TabTemplateModel',
            ],
        ];
    }
}
