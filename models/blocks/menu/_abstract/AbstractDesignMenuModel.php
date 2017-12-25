<?php

namespace testS\models\blocks\menu\_abstract;

use testS\models\_abstract\AbstractModel;

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
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'firstLevelDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'firstLevelDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'secondLevelDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'secondLevelDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'lastLevelDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'lastLevelDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
        ];
    }
}