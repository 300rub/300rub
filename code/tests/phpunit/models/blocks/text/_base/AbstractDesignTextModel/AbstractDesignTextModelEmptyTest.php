<?php

namespace ss\tests\phpunit\models\blocks\text\_base\AbstractDesignTextModel;

use ss\models\blocks\text\DesignTextModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model DesignTextModel
 */
class AbstractDesignTextModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTextModel
     */
    protected function getNewModel()
    {
        return new DesignTextModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => $this->_getDataProviderEmpty1(),
            'empty2' => $this->_getDataProviderEmpty2(),
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty1()
    {
        return [
            [],
            [
                'size'               => 0,
                'family'             => 0,
                'color'              => '',
                'isItalic'           => false,
                'isBold'             => false,
                'align'              => 0,
                'decoration'         => 0,
                'transform'          => 0,
                'letterSpacing'      => 0,
                'lineHeight'         => 0,
                'sizeHover'          => 0,
                'colorHover'         => '',
                'isItalicHover'      => false,
                'isBoldHover'        => false,
                'decorationHover'    => 0,
                'transformHover'     => 0,
                'letterSpacingHover' => 0,
                'lineHeightHover'    => 0,
            ],
            [
                'size'               => '',
                'family'             => '',
                'color'              => '',
                'isItalic'           => '',
                'isBold'             => '',
                'align'              => '',
                'decoration'         => '',
                'transform'          => '',
                'letterSpacing'      => '',
                'lineHeight'         => '',
                'sizeHover'          => '',
                'colorHover'         => '',
                'isItalicHover'      => '',
                'isBoldHover'        => '',
                'decorationHover'    => '',
                'transformHover'     => '',
                'letterSpacingHover' => '',
                'lineHeightHover'    => '',
            ],
            [
                'size'               => 0,
                'family'             => 0,
                'color'              => '',
                'isItalic'           => false,
                'isBold'             => false,
                'align'              => 0,
                'decoration'         => 0,
                'transform'          => 0,
                'letterSpacing'      => 0,
                'lineHeight'         => 0,
                'sizeHover'          => 0,
                'colorHover'         => '',
                'isItalicHover'      => false,
                'isBoldHover'        => false,
                'decorationHover'    => 0,
                'transformHover'     => 0,
                'letterSpacingHover' => 0,
                'lineHeightHover'    => 0,
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty2()
    {
        return [
            [
                'size'               => null,
                'family'             => null,
                'color'              => null,
                'isItalic'           => null,
                'isBold'             => null,
                'align'              => null,
                'decoration'         => null,
                'transform'          => null,
                'letterSpacing'      => null,
                'lineHeight'         => null,
                'sizeHover'          => null,
                'colorHover'         => null,
                'isItalicHover'      => null,
                'isBoldHover'        => null,
                'decorationHover'    => null,
                'transformHover'     => null,
                'letterSpacingHover' => null,
                'lineHeightHover'    => null,
            ],
            [
                'size'               => 0,
                'family'             => 0,
                'color'              => '',
                'isItalic'           => false,
                'isBold'             => false,
                'align'              => 0,
                'decoration'         => 0,
                'transform'          => 0,
                'letterSpacing'      => 0,
                'lineHeight'         => 0,
                'sizeHover'          => 0,
                'colorHover'         => '',
                'isItalicHover'      => false,
                'isBoldHover'        => false,
                'decorationHover'    => 0,
                'transformHover'     => 0,
                'letterSpacingHover' => 0,
                'lineHeightHover'    => 0,
            ],
            [
                'size'               => '  ',
                'family'             => '  ',
                'color'              => ' ',
                'isItalic'           => ' ',
                'isBold'             => ' ',
                'align'              => '  ',
                'decoration'         => '  ',
                'transform'          => '  ',
                'letterSpacing'      => '  ',
                'lineHeight'         => '  ',
                'sizeHover'          => '  ',
                'colorHover'         => '  ',
                'isItalicHover'      => '   ',
                'isBoldHover'        => '   ',
                'decorationHover'    => '  ',
                'transformHover'     => ' ',
                'letterSpacingHover' => '  ',
                'lineHeightHover'    => '   ',
            ],
            [
                'size'               => 0,
                'family'             => 0,
                'color'              => '',
                'isItalic'           => false,
                'isBold'             => false,
                'align'              => 0,
                'decoration'         => 0,
                'transform'          => 0,
                'letterSpacing'      => 0,
                'lineHeight'         => 0,
                'sizeHover'          => 0,
                'colorHover'         => '',
                'isItalicHover'      => false,
                'isBoldHover'        => false,
                'decorationHover'    => 0,
                'transformHover'     => 0,
                'letterSpacingHover' => 0,
                'lineHeightHover'    => 0,
            ],
        ];
    }
}
