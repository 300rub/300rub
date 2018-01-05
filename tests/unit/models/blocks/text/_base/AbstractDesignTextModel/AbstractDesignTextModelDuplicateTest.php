<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractDesignTextModel;

use testS\models\blocks\text\DesignTextModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model DesignTextModel
 */
class AbstractDesignTextModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
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
            ]
        );
    }
}
