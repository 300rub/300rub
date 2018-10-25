<?php

namespace ss\models\blocks\text\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "textInstanceFileMap"
 */
abstract class AbstractTextInstanceFileMapModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'textInstanceFileMap';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'textInstanceId'  => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\text\\TextInstanceModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'fileId'  => [
                self::FIELD_RELATION
                     => '  \\ss\\models\\blocks\\helpers\\file\\FileModel',
            ],
        ];
    }
}
