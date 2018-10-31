<?php

namespace ss\tests\phpunit\models\blocks\text\_base\AbstractDesignTextModel;

use ss\models\blocks\text\DesignTextModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model DesignTextModel
 */
class AbstractDesignTextModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => $this->_getDataProviderIncorrect1(),
            'incorrect2' => $this->_getDataProviderIncorrect2()
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect1()
    {
        return [
            [
                'size'               => [1],
                'family'             => [1],
                'color'              => new \stdClass(),
                'isItalic'           => [1],
                'isBold'             => [1],
                'align'              => [1],
                'decoration'         => [1],
                'transform'          => [1],
                'letterSpacing'      => [1],
                'lineHeight'         => new \stdClass(),
                'sizeHover'          => [1],
                'colorHover'         => [1],
                'isItalicHover'      => [1],
                'isBoldHover'        => new \stdClass(),
                'decorationHover'    => [1],
                'transformHover'     => [1],
                'letterSpacingHover' => new \stdClass(),
                'lineHeightHover'    => [1],
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
                'size'               => 'incorrect_type',
                'family'             => 'incorrect_type',
                'color'              => new \stdClass(),
                'isItalic'           => 'incorrect_type',
                'isBold'             => 'incorrect_type',
                'align'              => 'incorrect_type',
                'decoration'         => 'incorrect_type',
                'transform'          => 'incorrect_type',
                'letterSpacing'      => 'incorrect_type',
                'lineHeight'         => 'incorrect_type',
                'sizeHover'          => 'incorrect_type',
                'colorHover'         => [],
                'isItalicHover'      => 'incorrect_type',
                'isBoldHover'        => 'incorrect_type',
                'decorationHover'    => 'incorrect_type',
                'transformHover'     => 'incorrect_type',
                'letterSpacingHover' => 'incorrect_type',
                'lineHeightHover'    => 'incorrect_type',
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect2()
    {
        return [
            [
                'size'               => '20',
                'family'             => '1',
                'color'              => '   rgb(0,255,0)      ',
                'isItalic'           => 'true',
                'isBold'             => '1',
                'align'              => '  1  ',
                'decoration'         => '1',
                'transform'          => '3',
                'letterSpacing'      => '10',
                'lineHeight'         => '150',
                'sizeHover'          => '20',
                'colorHover'         => '   rgb(0,255,0)',
                'isItalicHover'      => '  true  ',
                'isBoldHover'        => '   1   ',
                'decorationHover'    => '1',
                'transformHover'     => '3',
                'letterSpacingHover' => '10',
                'lineHeightHover'    => '150',
            ],
            [
                'size'               => 20,
                'family'             => 1,
                'color'              => 'rgb(0,255,0)',
                'isItalic'           => true,
                'isBold'             => true,
                'align'              => 1,
                'decoration'         => 1,
                'transform'          => 3,
                'letterSpacing'      => 10,
                'lineHeight'         => 150,
                'sizeHover'          => 20,
                'colorHover'         => 'rgb(0,255,0)',
                'isItalicHover'      => true,
                'isBoldHover'        => true,
                'decorationHover'    => 1,
                'transformHover'     => 3,
                'letterSpacingHover' => 10,
                'lineHeightHover'    => 150,
            ],
            [
                'size'               => '30',
                'family'             => '5',
                'color'              => '  rgba(20,255,40,0.5)',
                'isItalic'           => ' false',
                'isBold'             => '0 ',
                'align'              => '2',
                'decoration'         => '2',
                'transform'          => ' 2 ',
                'isBoldHover'        => 0,
            ],
            [
                'size'               => 30,
                'family'             => 5,
                'color'              => 'rgba(20,255,40,0.5)',
                'isItalic'           => false,
                'isBold'             => false,
                'align'              => 2,
                'decoration'         => 2,
                'transform'          => 2,
                'letterSpacing'      => 10,
                'lineHeight'         => 150,
                'sizeHover'          => 20,
                'colorHover'         => 'rgb(0,255,0)',
                'isItalicHover'      => true,
                'isBoldHover'        => false,
                'decorationHover'    => 1,
                'transformHover'     => 3,
                'letterSpacingHover' => 10,
                'lineHeightHover'    => 150,
            ],
        ];
    }
}
