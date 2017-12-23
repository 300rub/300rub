<?php

namespace testS\models\blocks\helpers\form\_abstract;

use testS\application\App;
use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designForms"
 */
class AbstractDesignFormModel extends AbstractModel
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
    const SUBMIT_ALIGNMENT_RIGHT = 0;
    const SUBMIT_ALIGNMENT_LEFT = 1;
    const SUBMIT_ALIGNMENT_CENTER = 2;

    /**
     * Gets a list of submit icon positions
     *
     * @return array
     */
    public static function getSubmitIconPositionList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::SUBMIT_ICON_POSITION_NONE
                => $language->getMessage('common', 'none'),
            self::SUBMIT_ICON_POSITION_LEFT
                => $language->getMessage('common', 'left'),
            self::SUBMIT_ICON_POSITION_RIGHT
                => $language->getMessage('common', 'right'),
        ];
    }

    /**
     * Gets a list of submit alignments
     *
     * @return array
     */
    public static function getSubmitAlignmentList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::SUBMIT_ALIGNMENT_LEFT
                => $language->getMessage('common', 'left'),
            self::SUBMIT_ALIGNMENT_CENTER
                => $language->getMessage('common', 'center'),
            self::SUBMIT_ALIGNMENT_RIGHT
                => $language->getMessage('common', 'right'),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designForms';
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
            'lineDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'labelDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'labelDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'formDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'formDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'submitDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'submitDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'submitIconDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'submitIcon'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 50,
                ],
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ]
            ],
            'submitIconPosition'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getSubmitIconPositionList(),
                        self::SUBMIT_ICON_POSITION_NONE
                    ]
                ]
            ],
            'submitAlignment'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getSubmitAlignmentList(),
                        self::SUBMIT_ALIGNMENT_RIGHT
                    ]
                ]
            ],
        ];
    }
}
