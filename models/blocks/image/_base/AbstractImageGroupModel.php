<?php

namespace ss\models\blocks\image\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "imageGroups"
 */
abstract class AbstractImageGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'imageGroups';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'imageId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\image\\ImageModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'seoId'         => [
                self::FIELD_RELATION
                    => '\\ss\\models\\sections\\SeoModel'
            ],
            'containerDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'coverDesignBlockId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'nameDesignBlockId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'nameDesignTextId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'sort'    => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }
}
