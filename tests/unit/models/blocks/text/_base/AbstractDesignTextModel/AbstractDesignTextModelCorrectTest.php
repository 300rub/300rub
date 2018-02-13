<?php

namespace ss\tests\unit\models\blocks\text\_base\AbstractDesignTextModel;

use ss\models\blocks\text\DesignTextModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model DesignTextModel
 */
class AbstractDesignTextModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
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
                    'size'               => 30,
                    'family'             => 5,
                    'color'              => 'rgba(20,255,40,0.5)',
                    'isItalic'           => false,
                    'isBold'             => false,
                    'align'              => 2,
                    'decoration'         => 2,
                    'transform'          => 2,
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
                    'isBoldHover'        => true,
                    'decorationHover'    => 1,
                    'transformHover'     => 3,
                    'letterSpacingHover' => 10,
                    'lineHeightHover'    => 150,
                ],
            ]
        ];
    }
}
