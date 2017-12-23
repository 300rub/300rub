<?php

namespace testS\models\blocks\helpers\field\_abstract;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designFields"
 */
abstract class AbstractDesignFieldModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designFields';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'shortCardContainerDesignBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardLabelDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardLabelDesignTextId'      => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'shortCardValueDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardValueDesignTextId'      => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardContainerDesignBlockId'  => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardLabelDesignBlockId'      => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardLabelDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardValueDesignBlockId'      => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardValueDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
        ];
    }
}
