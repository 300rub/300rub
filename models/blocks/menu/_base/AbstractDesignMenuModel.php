<?php

namespace testS\models\blocks\menu\_base;

use testS\models\blocks\menu\_abstract\AbstractMenuModel;

/**
 * Abstract model for working with table "designMenu"
 */
abstract class AbstractDesignMenuModel extends AbstractMenuModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designMenu';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'firstLevelDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'firstLevelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'secondLevelDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'secondLevelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'lastLevelDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'lastLevelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
        ];
    }
}
