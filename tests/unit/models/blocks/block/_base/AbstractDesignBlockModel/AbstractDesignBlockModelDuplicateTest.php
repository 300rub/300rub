<?php

namespace testS\tests\unit\models\blocks\block\_base\AbstractDesignBlockModel;

use testS\models\blocks\block\DesignBlockModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model DesignBlockModel
 */
class AbstractDesignBlockModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return DesignBlockModel
     */
    protected function getNewModel()
    {
        return new DesignBlockModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            $this->_createData(),
            $this->_expectedData()
        );
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _createData()
    {
        return [
            'marginTop'                    => 10,
            'marginRight'                  => 20,
            'marginBottom'                 => 30,
            'marginLeft'                   => 40,
            'paddingTop'                   => 15,
            'paddingRight'                 => 25,
            'paddingBottom'                => 35,
            'paddingLeft'                  => 45,
            'backgroundColorFrom'          => 'rgba(255,255,255,0.5)',
            'backgroundColorTo'            => 'rgb(0,0,0)',
            'gradientDirection'            => 0,
            'borderTopWidth'               => 1,
            'borderTopLeftRadius'          => 5,
            'borderRightWidth'             => 2,
            'borderTopRightRadius'         => 10,
            'borderBottomWidth'            => 3,
            'borderBottomRightRadius'      => 15,
            'borderLeftWidth'              => 4,
            'borderBottomLeftRadius'       => 20,
            'borderColor'                  => 'rgba(0,255,255,0.5)',
            'borderStyle'                  => 1,
            'marginTopHover'               => 10,
            'marginRightHover'             => 20,
            'marginBottomHover'            => 30,
            'marginLeftHover'              => 40,
            'paddingTopHover'              => 15,
            'paddingRightHover'            => 25,
            'paddingBottomHover'           => 35,
            'paddingLeftHover'             => 45,
            'backgroundColorFromHover'     => 'rgba(255,255,255,0.5)',
            'backgroundColorToHover'       => 'rgb(0,0,0)',
            'gradientDirectionHover'       => 0,
            'borderTopWidthHover'          => 1,
            'borderTopLeftRadiusHover'     => 5,
            'borderRightWidthHover'        => 2,
            'borderTopRightRadiusHover'    => 10,
            'borderBottomWidthHover'       => 3,
            'borderBottomRightRadiusHover' => 15,
            'borderLeftWidthHover'         => 4,
            'borderBottomLeftRadiusHover'  => 20,
            'borderColorHover'             => 'rgba(0,255,255,0.5)',
            'borderStyleHover'             => 1,
            'hasMarginAnimation'           => true,
            'hasPaddingAnimation'          => true,
            'hasBackgroundAnimation'       => true,
            'hasBorderAnimation'           => true,
            'width'                        => 1024,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _expectedData()
    {
        return [
            'marginTop'                    => 10,
            'marginRight'                  => 20,
            'marginBottom'                 => 30,
            'marginLeft'                   => 40,
            'paddingTop'                   => 15,
            'paddingRight'                 => 25,
            'paddingBottom'                => 35,
            'paddingLeft'                  => 45,
            'backgroundColorFrom'          => 'rgba(255,255,255,0.5)',
            'backgroundColorTo'            => 'rgb(0,0,0)',
            'gradientDirection'            => 0,
            'borderTopWidth'               => 1,
            'borderTopLeftRadius'          => 5,
            'borderRightWidth'             => 2,
            'borderTopRightRadius'         => 10,
            'borderBottomWidth'            => 3,
            'borderBottomRightRadius'      => 15,
            'borderLeftWidth'              => 4,
            'borderBottomLeftRadius'       => 20,
            'borderColor'                  => 'rgba(0,255,255,0.5)',
            'borderStyle'                  => 1,
            'marginTopHover'               => 10,
            'marginRightHover'             => 20,
            'marginBottomHover'            => 30,
            'marginLeftHover'              => 40,
            'paddingTopHover'              => 15,
            'paddingRightHover'            => 25,
            'paddingBottomHover'           => 35,
            'paddingLeftHover'             => 45,
            'backgroundColorFromHover'     => 'rgba(255,255,255,0.5)',
            'backgroundColorToHover'       => 'rgb(0,0,0)',
            'gradientDirectionHover'       => 0,
            'borderTopWidthHover'          => 1,
            'borderTopLeftRadiusHover'     => 5,
            'borderRightWidthHover'        => 2,
            'borderTopRightRadiusHover'    => 10,
            'borderBottomWidthHover'       => 3,
            'borderBottomRightRadiusHover' => 15,
            'borderLeftWidthHover'         => 4,
            'borderBottomLeftRadiusHover'  => 20,
            'borderColorHover'             => 'rgba(0,255,255,0.5)',
            'borderStyleHover'             => 1,
            'hasMarginAnimation'           => true,
            'hasPaddingAnimation'          => true,
            'hasBackgroundAnimation'       => true,
            'hasBorderAnimation'           => true,
            'width'                        => 1024,
        ];
    }
}
