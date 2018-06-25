<?php

namespace ss\models\blocks\image\_base;

use ss\application\components\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designImageZooms"
 */
abstract class AbstractDesignImageZoomModel extends AbstractModel
{

    /**
     * Thumbs alignments
     */
    const THUMBS_ALIGNMENT_NONE = 0;
    const THUMBS_ALIGNMENT_TOP = 1;
    const THUMBS_ALIGNMENT_LEFT = 2;
    const THUMBS_ALIGNMENT_RIGHT = 3;
    const THUMBS_ALIGNMENT_BOTTOM = 4;

    /**
     * Effects
     */
    const EFFECT_NONE = 0;

    /**
     * Gets thumbs alignment list
     *
     * @return array
     */
    public static function getThumbsAlignmentList()
    {
        return [
            self::THUMBS_ALIGNMENT_NONE   => '',
            self::THUMBS_ALIGNMENT_TOP    => '',
            self::THUMBS_ALIGNMENT_LEFT   => '',
            self::THUMBS_ALIGNMENT_RIGHT  => '',
            self::THUMBS_ALIGNMENT_BOTTOM => ''
        ];
    }

    /**
     * Gets a list of effects
     *
     * @return array
     */
    public static function getEffectList()
    {
        return [
            self::EFFECT_NONE => ''
        ];
    }

    /**
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        return [];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designImageZooms';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'designBlockId'        => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'effect'               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getEffectList(),
                        self::EFFECT_NONE
                    ]
                ],
            ],
        ];
    }
}
