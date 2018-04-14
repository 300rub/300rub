<?php

namespace ss\models\blocks\image\_base;

use ss\application\components\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designImageSliders"
 */
abstract class AbstractDesignImageSliderModel extends AbstractModel
{

    /**
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        return [
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designImageSliders';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'arrowDesignTextId'       => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'bulletDesignBlockId'  => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'bulletActiveDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'descriptionDesignBlockId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'descriptionDesignTextId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'effect'                   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING
            ],
            'hasAutoPlay'              => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'playSpeed'                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
        ];
    }
}
