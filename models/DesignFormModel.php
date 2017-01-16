<?php

namespace testS\models;

use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "designForms"
 *
 * @package testS\models
 */
class DesignFormModel extends AbstractModel
{

    /**
     * Submit icon positions
     */
    const SUBMIT_ICON_POSITION_NONE = 0;
    const SUBMIT_ICON_POSITION_LEFT = 1;
    const SUBMIT_ICON_POSITION_RIGHT = 2;

    /**
     * Submit alignments
     */
    const SUBMIT_ALIGNMENT_LEFT = 0;
    const SUBMIT_ALIGNMENT_CENTER = 1;
    const SUBMIT_ALIGNMENT_RIGHT = 2;

    /**
     * Gets a list of submit icon positions
     *
     * @return array
     */
    public static function getSubmitIconPositionList()
    {
        return [
            self::SUBMIT_ICON_POSITION_NONE  => Language::t("common", "none"),
            self::SUBMIT_ICON_POSITION_LEFT  => Language::t("common", "left"),
            self::SUBMIT_ICON_POSITION_RIGHT => Language::t("common", "right"),
        ];
    }

    /**
     * Gets a list of submit alignments
     *
     * @return array
     */
    public static function getSubmitAlignmentList()
    {
        return [
            self::SUBMIT_ALIGNMENT_LEFT   => Language::t("common", "left"),
            self::SUBMIT_ALIGNMENT_CENTER => Language::t("common", "center"),
            self::SUBMIT_ALIGNMENT_RIGHT  => Language::t("common", "right"),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designForms";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "containerDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "lineDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "labelDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "labelDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "formDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "formDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "submitDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "submitDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "submitIconDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "submitIcon"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 50
                ]
            ],
            "submitIconPosition"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [
                        self::getSubmitIconPositionList(),
                        self::SUBMIT_ICON_POSITION_NONE
                    ]
                ]
            ],
            "submitAlignment"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [
                        self::getSubmitAlignmentList(),
                        self::SUBMIT_ALIGNMENT_RIGHT
                    ]
                ]
            ],
        ];
    }
}