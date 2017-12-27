<?php

namespace testS\models\blocks\helpers\tab\_base;

use testS\models\blocks\helpers\tab\_abstract\AbstractTabModel;

/**
 * Abstract model for working with table "tabInstances"
 */
abstract class AbstractTabInstanceModel extends AbstractTabModel
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
                    => '\\testS\\models\\blocks\\helpers\\tab\\TabGroupModel',
            ],
            'textInstanceId' => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\TextInstanceModel',
            ],
            'tabTemplateId'  => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\helpers\\' .
                        'tab\\TabTemplateModel',
            ],
        ];
    }
}
