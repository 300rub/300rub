<?php

namespace testS\models\blocks\image\_base;

use testS\application\components\ValueGenerator;
use testS\models\blocks\image\_abstract\AbstractImageModel;

/**
 * Abstract model for working with table "designImageSimple"
 */
abstract class AbstractDesignImageSimpleModel extends AbstractImageModel
{

    /**
     * Alignments
     */
    const ALIGNMENT_LEFT = 0;
    const ALIGNMENT_CENTER = 1;
    const ALIGNMENT_RIGHT = 2;

    /**
     * Gets alignment list
     *
     * @return array
     */
    public static function getAlignmentList()
    {
        return [
            self::ALIGNMENT_LEFT   => '',
            self::ALIGNMENT_CENTER => '',
            self::ALIGNMENT_RIGHT  => ''
        ];
    }

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
        return 'designImageSimple';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId'      => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'imageDesignBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'alignment'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getAlignmentList(),
                        self::ALIGNMENT_LEFT
                    ]
                ],
            ]
        ];
    }
}
