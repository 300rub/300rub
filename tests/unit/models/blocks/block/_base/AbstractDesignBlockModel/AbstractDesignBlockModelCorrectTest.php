<?php

namespace testS\tests\unit\models\blocks\block\_base\AbstractDesignBlockModel;

use testS\models\blocks\block\DesignBlockModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model DesignBlockModel
 */
class AbstractDesignBlockModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                $this->_createData1(),
                $this->_checkCreateData1(),
                $this->_updateData1(),
                $this->_checkUpdateData1()
            ],
            'correct2' => [
                $this->_createData2(),
                $this->_checkCreateData2(),
                $this->_updateData2(),
                $this->_checkUpdateData2()
            ]
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData1()
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _checkCreateData1()
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData1()
    {
        return [
            'marginTop'                    => 5,
            'marginRight'                  => 6,
            'marginBottom'                 => 7,
            'marginLeft'                   => 8,
            'paddingTop'                   => 9,
            'paddingRight'                 => 10,
            'paddingBottom'                => 11,
            'paddingLeft'                  => 12,
            'backgroundColorFrom'          => 'rgba(255,0,255,0.5)',
            'backgroundColorTo'            => 'rgba(255,255,0,0.5)',
            'gradientDirection'            => 1,
            'borderTopWidth'               => 3,
            'borderTopLeftRadius'          => 4,
            'borderRightWidth'             => 5,
            'borderTopRightRadius'         => 6,
            'borderBottomWidth'            => 7,
            'borderBottomRightRadius'      => 8,
            'borderLeftWidth'              => 9,
            'borderBottomLeftRadius'       => 10,
            'borderColor'                  => 'rgb(0,255,0)',
            'borderStyle'                  => 2,
            'marginTopHover'               => 5,
            'marginRightHover'             => 6,
            'marginBottomHover'            => 7,
            'marginLeftHover'              => 8,
            'paddingTopHover'              => 9,
            'paddingRightHover'            => 10,
            'paddingBottomHover'           => 11,
            'paddingLeftHover'             => 12,
            'backgroundColorFromHover'     => 'rgba(255,0,255,0.5)',
            'backgroundColorToHover'       => 'rgba(255,255,0,0.5)',
            'gradientDirectionHover'       => 1,
            'borderTopWidthHover'          => 3,
            'borderTopLeftRadiusHover'     => 4,
            'borderRightWidthHover'        => 5,
            'borderTopRightRadiusHover'    => 6,
            'borderBottomWidthHover'       => 7,
            'borderBottomRightRadiusHover' => 8,
            'borderLeftWidthHover'         => 9,
            'borderBottomLeftRadiusHover'  => 10,
            'borderColorHover'             => 'rgb(0,255,0)',
            'borderStyleHover'             => 2,
            'hasMarginAnimation'           => false,
            'hasPaddingAnimation'          => false,
            'hasBackgroundAnimation'       => false,
            'hasBorderAnimation'           => false,
            'width'                        => 980,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _checkUpdateData1()
    {
        return [
            'marginTop'                    => 5,
            'marginRight'                  => 6,
            'marginBottom'                 => 7,
            'marginLeft'                   => 8,
            'paddingTop'                   => 9,
            'paddingRight'                 => 10,
            'paddingBottom'                => 11,
            'paddingLeft'                  => 12,
            'backgroundColorFrom'          => 'rgba(255,0,255,0.5)',
            'backgroundColorTo'            => 'rgba(255,255,0,0.5)',
            'gradientDirection'            => 1,
            'borderTopWidth'               => 3,
            'borderTopLeftRadius'          => 4,
            'borderRightWidth'             => 5,
            'borderTopRightRadius'         => 6,
            'borderBottomWidth'            => 7,
            'borderBottomRightRadius'      => 8,
            'borderLeftWidth'              => 9,
            'borderBottomLeftRadius'       => 10,
            'borderColor'                  => 'rgb(0,255,0)',
            'borderStyle'                  => 2,
            'marginTopHover'               => 5,
            'marginRightHover'             => 6,
            'marginBottomHover'            => 7,
            'marginLeftHover'              => 8,
            'paddingTopHover'              => 9,
            'paddingRightHover'            => 10,
            'paddingBottomHover'           => 11,
            'paddingLeftHover'             => 12,
            'backgroundColorFromHover'     => 'rgba(255,0,255,0.5)',
            'backgroundColorToHover'       => 'rgba(255,255,0,0.5)',
            'gradientDirectionHover'       => 1,
            'borderTopWidthHover'          => 3,
            'borderTopLeftRadiusHover'     => 4,
            'borderRightWidthHover'        => 5,
            'borderTopRightRadiusHover'    => 6,
            'borderBottomWidthHover'       => 7,
            'borderBottomRightRadiusHover' => 8,
            'borderLeftWidthHover'         => 9,
            'borderBottomLeftRadiusHover'  => 10,
            'borderColorHover'             => 'rgb(0,255,0)',
            'borderStyleHover'             => 2,
            'hasMarginAnimation'           => false,
            'hasPaddingAnimation'          => false,
            'hasBackgroundAnimation'       => false,
            'hasBorderAnimation'           => false,
            'width'                        => 980,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData2()
    {
        return [
            'marginTop'                    => 5,
            'marginRight'                  => 6,
            'marginBottom'                 => 7,
            'marginLeft'                   => 8,
            'paddingTop'                   => 9,
            'paddingRight'                 => 10,
            'paddingBottom'                => 11,
            'paddingLeft'                  => 12,
            'backgroundColorFrom'          => 'rgba(255,0,255,0.5)',
            'backgroundColorTo'            => 'rgba(255,255,0,0.5)',
            'gradientDirection'            => 1,
            'borderTopWidth'               => 3,
            'borderTopLeftRadius'          => 4,
            'borderRightWidth'             => 5,
            'borderTopRightRadius'         => 6,
            'borderBottomWidth'            => 7,
            'borderBottomRightRadius'      => 8,
            'borderLeftWidth'              => 9,
            'borderBottomLeftRadius'       => 10,
            'borderColor'                  => 'rgb(0,255,0)',
            'borderStyle'                  => 2,
            'marginTopHover'               => 5,
            'marginRightHover'             => 6,
            'marginBottomHover'            => 7,
            'marginLeftHover'              => 8,
            'paddingTopHover'              => 9,
            'paddingRightHover'            => 10,
            'paddingBottomHover'           => 11,
            'paddingLeftHover'             => 12,
            'backgroundColorFromHover'     => 'rgba(255,0,255,0.5)',
            'backgroundColorToHover'       => 'rgba(255,255,0,0.5)',
            'gradientDirectionHover'       => 1,
            'borderTopWidthHover'          => 3,
            'borderTopLeftRadiusHover'     => 4,
            'borderRightWidthHover'        => 5,
            'borderTopRightRadiusHover'    => 6,
            'borderBottomWidthHover'       => 7,
            'borderBottomRightRadiusHover' => 8,
            'borderLeftWidthHover'         => 9,
            'borderBottomLeftRadiusHover'  => 10,
            'borderColorHover'             => 'rgb(0,255,0)',
            'borderStyleHover'             => 2,
            'hasMarginAnimation'           => false,
            'hasPaddingAnimation'          => false,
            'hasBackgroundAnimation'       => false,
            'hasBorderAnimation'           => false,
            'width'                        => 980,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _checkCreateData2()
    {
        return [
            'marginTop'                    => 5,
            'marginRight'                  => 6,
            'marginBottom'                 => 7,
            'marginLeft'                   => 8,
            'paddingTop'                   => 9,
            'paddingRight'                 => 10,
            'paddingBottom'                => 11,
            'paddingLeft'                  => 12,
            'backgroundColorFrom'          => 'rgba(255,0,255,0.5)',
            'backgroundColorTo'            => 'rgba(255,255,0,0.5)',
            'gradientDirection'            => 1,
            'borderTopWidth'               => 3,
            'borderTopLeftRadius'          => 4,
            'borderRightWidth'             => 5,
            'borderTopRightRadius'         => 6,
            'borderBottomWidth'            => 7,
            'borderBottomRightRadius'      => 8,
            'borderLeftWidth'              => 9,
            'borderBottomLeftRadius'       => 10,
            'borderColor'                  => 'rgb(0,255,0)',
            'borderStyle'                  => 2,
            'marginTopHover'               => 5,
            'marginRightHover'             => 6,
            'marginBottomHover'            => 7,
            'marginLeftHover'              => 8,
            'paddingTopHover'              => 9,
            'paddingRightHover'            => 10,
            'paddingBottomHover'           => 11,
            'paddingLeftHover'             => 12,
            'backgroundColorFromHover'     => 'rgba(255,0,255,0.5)',
            'backgroundColorToHover'       => 'rgba(255,255,0,0.5)',
            'gradientDirectionHover'       => 1,
            'borderTopWidthHover'          => 3,
            'borderTopLeftRadiusHover'     => 4,
            'borderRightWidthHover'        => 5,
            'borderTopRightRadiusHover'    => 6,
            'borderBottomWidthHover'       => 7,
            'borderBottomRightRadiusHover' => 8,
            'borderLeftWidthHover'         => 9,
            'borderBottomLeftRadiusHover'  => 10,
            'borderColorHover'             => 'rgb(0,255,0)',
            'borderStyleHover'             => 2,
            'hasMarginAnimation'           => false,
            'hasPaddingAnimation'          => false,
            'hasBackgroundAnimation'       => false,
            'hasBorderAnimation'           => false,
            'width'                        => 980,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData2()
    {
        return [
            'marginTop'                    => 0,
            'marginTopHover'               => 0,
            'marginRight'                  => 0,
            'marginRightHover'             => 0,
            'marginBottom'                 => 0,
            'marginBottomHover'            => 0,
            'marginLeft'                   => 0,
            'marginLeftHover'              => 0,
            'hasMarginAnimation'           => false,
            'paddingTop'                   => 0,
            'paddingTopHover'              => 0,
            'paddingRight'                 => 0,
            'paddingRightHover'            => 0,
            'paddingBottom'                => 0,
            'paddingBottomHover'           => 0,
            'paddingLeft'                  => 0,
            'paddingLeftHover'             => 0,
            'hasPaddingAnimation'          => false,
            'backgroundColorFrom'          => '',
            'backgroundColorFromHover'     => '',
            'backgroundColorTo'            => '',
            'backgroundColorToHover'       => '',
            'gradientDirection'            => 0,
            'gradientDirectionHover'       => 0,
            'hasBackgroundAnimation'       => false,
            'borderTopWidth'               => 0,
            'borderTopWidthHover'          => 0,
            'borderTopLeftRadius'          => 0,
            'borderTopLeftRadiusHover'     => 0,
            'borderRightWidth'             => 0,
            'borderRightWidthHover'        => 0,
            'borderTopRightRadius'         => 0,
            'borderTopRightRadiusHover'    => 0,
            'borderBottomWidth'            => 0,
            'borderBottomWidthHover'       => 0,
            'borderBottomRightRadius'      => 0,
            'borderBottomRightRadiusHover' => 0,
            'borderLeftWidth'              => 0,
            'borderLeftWidthHover'         => 0,
            'borderBottomLeftRadius'       => 0,
            'borderBottomLeftRadiusHover'  => 0,
            'borderColor'                  => '',
            'borderColorHover'             => '',
            'borderStyle'                  => 0,
            'borderStyleHover'             => 0,
            'hasBorderAnimation'           => false,
            'width'                        => 0,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _checkUpdateData2()
    {
        return [
            'marginTop'                    => 0,
            'marginTopHover'               => 0,
            'marginRight'                  => 0,
            'marginRightHover'             => 0,
            'marginBottom'                 => 0,
            'marginBottomHover'            => 0,
            'marginLeft'                   => 0,
            'marginLeftHover'              => 0,
            'hasMarginAnimation'           => false,
            'paddingTop'                   => 0,
            'paddingTopHover'              => 0,
            'paddingRight'                 => 0,
            'paddingRightHover'            => 0,
            'paddingBottom'                => 0,
            'paddingBottomHover'           => 0,
            'paddingLeft'                  => 0,
            'paddingLeftHover'             => 0,
            'hasPaddingAnimation'          => false,
            'backgroundColorFrom'          => '',
            'backgroundColorFromHover'     => '',
            'backgroundColorTo'            => '',
            'backgroundColorToHover'       => '',
            'gradientDirection'            => 0,
            'gradientDirectionHover'       => 0,
            'hasBackgroundAnimation'       => false,
            'borderTopWidth'               => 0,
            'borderTopWidthHover'          => 0,
            'borderTopLeftRadius'          => 0,
            'borderTopLeftRadiusHover'     => 0,
            'borderRightWidth'             => 0,
            'borderRightWidthHover'        => 0,
            'borderTopRightRadius'         => 0,
            'borderTopRightRadiusHover'    => 0,
            'borderBottomWidth'            => 0,
            'borderBottomWidthHover'       => 0,
            'borderBottomRightRadius'      => 0,
            'borderBottomRightRadiusHover' => 0,
            'borderLeftWidth'              => 0,
            'borderLeftWidthHover'         => 0,
            'borderBottomLeftRadius'       => 0,
            'borderBottomLeftRadiusHover'  => 0,
            'borderColor'                  => '',
            'borderColorHover'             => '',
            'borderStyle'                  => 0,
            'borderStyleHover'             => 0,
            'hasBorderAnimation'           => false,
            'width'                        => 0,
        ];
    }
}
