<?php

namespace ss\models\blocks\menu\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designMenu"
 */
abstract class AbstractDesignMenuModel extends AbstractModel
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
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'firstLevelDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'firstLevelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'firstLevelActiveDesignBlockId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'firstLevelActiveDesignTextId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'secondLevelDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'secondLevelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'secondLevelActiveDesignBlockId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'secondLevelActiveDesignTextId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'lastLevelDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'lastLevelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'lastLevelActiveDesignBlockId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'lastLevelActiveDesignTextId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
        ];
    }
}
