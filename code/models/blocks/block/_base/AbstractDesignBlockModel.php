<?php

namespace ss\models\blocks\block\_base;

use ss\application\App;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\_abstract\AbstractDesignModel;

/**
 * Abstract model for working with table "designBlocks"
 */
abstract class AbstractDesignBlockModel extends AbstractDesignModel
{

    /**
     * Type
     */
    const TYPE = 'block';

    /**
     * Min margin value
     */
    const MIN_MARGIN_VALUE = -300;

    /**
     * Min border width value
     */
    const MIN_BORDER_WIDTH_VALUE = 0;

    /**
     * Gradient directions
     */
    const GRADIENT_DIRECTION_HORIZONTAL = 0;
    const GRADIENT_DIRECTION_VERTICAL = 1;
    const GRADIENT_DIRECTION_135DEG = 2;
    const GRADIENT_DIRECTION_45DEG = 3;

    /**
     * Border styles
     */
    const BORDER_STYLE_SOLID = 0;
    const BORDER_STYLE_DOTTED = 1;
    const BORDER_STYLE_DASHED = 2;

    /**
     * Background repeat
     */
    const BACKGROUND_REPEAT_NONE = 0;
    const BACKGROUND_REPEAT_X = 1;
    const BACKGROUND_REPEAT_Y = 2;
    const BACKGROUND_REPEAT_ALL = 3;

    /**
     * Background position
     */
    const BACKGROUND_POSITION_LEFT_TOP = 0;
    const BACKGROUND_POSITION_CENTER_TOP = 1;
    const BACKGROUND_POSITION_RIGHT_TOP = 2;
    const BACKGROUND_POSITION_LEFT_CENTER = 3;
    const BACKGROUND_POSITION_CENTER_CENTER = 4;
    const BACKGROUND_POSITION_RIGHT_CENTER = 5;
    const BACKGROUND_POSITION_LEFT_BOTTOM = 6;
    const BACKGROUND_POSITION_CENTER_BOTTOM = 7;
    const BACKGROUND_POSITION_RIGHT_BOTTOM = 8;

    /**
     * Gets background repeat list
     *
     * @return array
     */
    protected function getBackgroundRepeatList()
    {
        return [
            self::BACKGROUND_REPEAT_NONE => '',
            self::BACKGROUND_REPEAT_X => '',
            self::BACKGROUND_REPEAT_Y => '',
            self::BACKGROUND_REPEAT_ALL => '',
        ];
    }

    /**
     * Gets background position list
     *
     * @return array
     */
    protected function getBackgroundPositionList()
    {
        return [
            self::BACKGROUND_POSITION_LEFT_TOP => '',
            self::BACKGROUND_POSITION_CENTER_TOP => '',
            self::BACKGROUND_POSITION_RIGHT_TOP => '',
            self::BACKGROUND_POSITION_LEFT_CENTER => '',
            self::BACKGROUND_POSITION_CENTER_CENTER => '',
            self::BACKGROUND_POSITION_RIGHT_CENTER => '',
            self::BACKGROUND_POSITION_LEFT_BOTTOM => '',
            self::BACKGROUND_POSITION_CENTER_BOTTOM => '',
            self::BACKGROUND_POSITION_RIGHT_BOTTOM => '',
        ];
    }

    /**
     * List of gradient directions options
     *
     * @var array
     */
    public static $gradientDirections = [
        self::GRADIENT_DIRECTION_HORIZONTAL => [
            'mozLinear'    => 'left',
            'webkit'       => 'linear, left top, right top',
            'webkitLinear' => 'left',
            'oLinear'      => 'left',
            'msLinear'     => 'left',
            'linear'       => 'to right',
            'ie'           => 1,
        ],
        self::GRADIENT_DIRECTION_VERTICAL   => [
            'mozLinear'    => 'top',
            'webkit'       => 'linear, left top, left bottom',
            'webkitLinear' => 'top',
            'oLinear'      => 'top',
            'msLinear'     => 'top',
            'linear'       => 'to bottom',
            'ie'           => 0,
        ],
        self::GRADIENT_DIRECTION_135DEG     => [
            'mozLinear'    => '-45deg',
            'webkit'       => 'linear, left top, right bottom',
            'webkitLinear' => '-45deg',
            'oLinear'      => '-45deg',
            'msLinear'     => '-45deg',
            'linear'       => '135deg',
            'ie'           => 1,
        ],
        self::GRADIENT_DIRECTION_45DEG      => [
            'mozLinear'    => '45deg',
            'webkit'       => 'linear, left bottom, right top',
            'webkitLinear' => '45deg',
            'oLinear'      => '45deg',
            'msLinear'     => '45deg',
            'linear'       => '45deg',
            'ie'           => 1,
        ],
    ];

    /**
     * List of border styles
     *
     * @var array
     */
    public static $borderStyles = [
        self::BORDER_STYLE_SOLID  => 'solid',
        self::BORDER_STYLE_DOTTED => 'dotted',
        self::BORDER_STYLE_DASHED => 'dashed',
    ];

    /**
     * Gets labels
     *
     * @return array
     */
    protected function getLabels()
    {
        $language = App::getInstance()->getLanguage();

        return [
            'margin'                 => $language
                ->getMessage('design', 'margin'),
            'padding'                => $language
                ->getMessage('design', 'padding'),
            'mouseHoverEffect'       => $language
                ->getMessage('design', 'mouseHoverEffect'),
            'mouseHoverAnimation'    => $language
                ->getMessage('design', 'mouseHoverAnimation'),
            'backgroundColor'        => $language
                ->getMessage('design', 'backgroundColor'),
            'backgroundImage'        => $language
                ->getMessage('design', 'backgroundImage'),
            'borderColor'            => $language
                ->getMessage('design', 'borderColor'),
            'borderColorHover'       => $language
                ->getMessage('design', 'borderColorHover'),
            'useGradient'            => $language
                ->getMessage('design', 'useGradient'),
            'border'                 => $language
                ->getMessage('design', 'border'),
            'gradientDirection'      => $language
                ->getMessage('design', 'gradientDirection'),
            'gradientDirectionHover' => $language
                ->getMessage('design', 'gradientDirectionHover'),
            'cancel'                 => $language
                ->getMessage('common', 'cancel'),
            'save'                   => $language
                ->getMessage('common', 'save'),
            'clear'                  => $language
                ->getMessage('common', 'clear'),
            'borderStyle'            => $language
                ->getMessage('design', 'borderStyle'),
            'borderStyleHover'       => $language
                ->getMessage('design', 'borderStyleHover'),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designBlocks';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return array_merge(
            $this->_getMarginFieldsInfo(),
            $this->_getPaddingFieldsInfo(),
            $this->_getBackgroundFieldsInfo(),
            $this->_getBorderRadiusFieldsInfo(),
            $this->_getBorderWidthFieldsInfo(),
            $this->_getBorderStyleFieldsInfo(),
            $this->_getCommonFieldsInfo()
        );
    }

    /**
     * Gets margin fields info
     *
     * @return array
     */
    private function _getMarginFieldsInfo()
    {
        return [
            'marginTop'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginTopHover'     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginRight'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginRightHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginBottom'       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginBottomHover'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginLeft'         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'marginLeftHover'    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            'hasMarginHover'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'hasMarginAnimation' => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Gets padding fields info
     *
     * @return array
     */
    private function _getPaddingFieldsInfo()
    {
        return [
            'paddingTop'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingTopHover'     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingRight'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingRightHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingBottom'       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingBottomHover'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingLeft'         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'paddingLeftHover'    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'hasPaddingHover'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'hasPaddingAnimation' => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Gets background fields info
     *
     * @return array
     */
    private function _getBackgroundFieldsInfo()
    {
        return [
            'backgroundColorFrom'      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            'backgroundColorFromHover' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            'backgroundColorTo'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            'backgroundColorToHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            'gradientDirection'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::$gradientDirections,
                        self::GRADIENT_DIRECTION_HORIZONTAL
                    ]
                ],
            ],
            'gradientDirectionHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::$gradientDirections,
                        self::GRADIENT_DIRECTION_HORIZONTAL
                    ]
                ],
            ],
            'hasBackgroundGradient'    => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'hasBackgroundHover'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'hasBackgroundAnimation'   => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'imageInstanceId'              => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\image\\ImageInstanceModel',
                self::FIELD_ALLOW_NULL => true,
            ],
            'backgroundPosition'           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getBackgroundPositionList(),
                        self::BACKGROUND_POSITION_LEFT_TOP
                    ]
                ],
            ],
            'backgroundRepeat'             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getBackgroundRepeatList(),
                        self::BACKGROUND_REPEAT_NONE
                    ]
                ],
            ],
            'isBackgroundCover'            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Gets border radius fields info
     *
     * @return array
     */
    private function _getBorderRadiusFieldsInfo()
    {
        return [
            'borderTopLeftRadius'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderTopLeftRadiusHover'     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderTopRightRadius'         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderTopRightRadiusHover'    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderBottomRightRadius'      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderBottomRightRadiusHover' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderBottomLeftRadius'       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderBottomLeftRadiusHover'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
        ];
    }

    /**
     * Gets border width fields info
     *
     * @return array
     */
    private function _getBorderWidthFieldsInfo()
    {
        return [
            'borderTopWidth'         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderTopWidthHover'    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderRightWidth'       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderRightWidthHover'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderBottomWidth'      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderBottomWidthHover' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderLeftWidth'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'borderLeftWidthHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
        ];
    }

    /**
     * Gets border style fields info
     *
     * @return array
     */
    private function _getBorderStyleFieldsInfo()
    {
        return [
            'borderColor'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            'borderColorHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            'borderStyle'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::$borderStyles,
                        self::BORDER_STYLE_SOLID
                    ]
                ],
            ],
            'borderStyleHover'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::$borderStyles,
                        self::BORDER_STYLE_SOLID
                    ]
                ],
            ],
            'hasBorderHover'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            'hasBorderAnimation' => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Gets common fields info
     *
     * @return array
     */
    private function _getCommonFieldsInfo()
    {
        return [
            'width' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            'height' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
        ];
    }
}
