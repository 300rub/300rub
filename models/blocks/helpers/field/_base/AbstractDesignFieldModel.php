<?php

namespace testS\models\blocks\helpers\field\_base;

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
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardLabelDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardLabelDesignTextId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardValueDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardValueDesignTextId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardContainerDesignBlockId'  => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardLabelDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardLabelDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardValueDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardValueDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
        ];
    }
}
