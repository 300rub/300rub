<?php

namespace ss\tests\phpunit\models\blocks\block\_base\AbstractDesignBlockModel;

use ss\models\blocks\block\DesignBlockModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model DesignBlockModel
 */
class AbstractDesignBlockModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                $this->_checkCreateData1(),
                $this->_updateData1(),
                $this->_checkUpdateData1()
            ],
            'empty2' => [
                $this->_createData2(),
                $this->_checkCreateData2(),
                $this->_updateData2(),
                $this->_checkUpdateData2()
            ]
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _checkCreateData1()
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateData1()
    {
        return [
            'marginTop'                    => '',
            'marginRight'                  => '',
            'marginBottom'                 => '',
            'marginLeft'                   => '',
            'paddingTop'                   => '',
            'paddingRight'                 => '',
            'paddingBottom'                => '',
            'paddingLeft'                  => '',
            'backgroundColorFrom'          => '',
            'backgroundColorTo'            => '',
            'gradientDirection'            => '',
            'borderTopWidth'               => '',
            'borderTopLeftRadius'          => '',
            'borderRightWidth'             => '',
            'borderTopRightRadius'         => '',
            'borderBottomWidth'            => '',
            'borderBottomRightRadius'      => '',
            'borderLeftWidth'              => '',
            'borderBottomLeftRadius'       => '',
            'borderColor'                  => '',
            'borderStyle'                  => '',
            'marginTopHover'               => '',
            'marginRightHover'             => '',
            'marginBottomHover'            => '',
            'marginLeftHover'              => '',
            'paddingTopHover'              => '',
            'paddingRightHover'            => '',
            'paddingBottomHover'           => '',
            'paddingLeftHover'             => '',
            'backgroundColorFromHover'     => '',
            'backgroundColorToHover'       => '',
            'gradientDirectionHover'       => '',
            'borderTopWidthHover'          => '',
            'borderTopLeftRadiusHover'     => '',
            'borderRightWidthHover'        => '',
            'borderTopRightRadiusHover'    => '',
            'borderBottomWidthHover'       => '',
            'borderBottomRightRadiusHover' => '',
            'borderLeftWidthHover'         => '',
            'borderBottomLeftRadiusHover'  => '',
            'borderColorHover'             => '',
            'borderStyleHover'             => '',
            'hasMarginAnimation'           => '',
            'hasPaddingAnimation'          => '',
            'hasBackgroundAnimation'       => '',
            'hasBorderAnimation'           => '',
            'width'                        => '',
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _checkUpdateData1()
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createData2()
    {
        return [
            'marginTop'                    => null,
            'marginRight'                  => null,
            'marginBottom'                 => null,
            'marginLeft'                   => null,
            'paddingTop'                   => null,
            'paddingRight'                 => null,
            'paddingBottom'                => null,
            'paddingLeft'                  => null,
            'backgroundColorFrom'          => null,
            'backgroundColorTo'            => null,
            'gradientDirection'            => null,
            'borderTopWidth'               => null,
            'borderTopLeftRadius'          => null,
            'borderRightWidth'             => null,
            'borderTopRightRadius'         => null,
            'borderBottomWidth'            => null,
            'borderBottomRightRadius'      => null,
            'borderLeftWidth'              => null,
            'borderBottomLeftRadius'       => null,
            'borderColor'                  => null,
            'borderStyle'                  => null,
            'marginTopHover'               => null,
            'marginRightHover'             => null,
            'marginBottomHover'            => null,
            'marginLeftHover'              => null,
            'paddingTopHover'              => null,
            'paddingRightHover'            => null,
            'paddingBottomHover'           => null,
            'paddingLeftHover'             => null,
            'backgroundColorFromHover'     => null,
            'backgroundColorToHover'       => null,
            'gradientDirectionHover'       => null,
            'borderTopWidthHover'          => null,
            'borderTopLeftRadiusHover'     => null,
            'borderRightWidthHover'        => null,
            'borderTopRightRadiusHover'    => null,
            'borderBottomWidthHover'       => null,
            'borderBottomRightRadiusHover' => null,
            'borderLeftWidthHover'         => null,
            'borderBottomLeftRadiusHover'  => null,
            'borderColorHover'             => null,
            'borderStyleHover'             => null,
            'hasMarginAnimation'           => null,
            'hasPaddingAnimation'          => null,
            'hasBackgroundAnimation'       => null,
            'hasBorderAnimation'           => null,
            'width'                        => null,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _checkCreateData2()
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateData2()
    {
        return [
            'marginTop'                    => '  ',
            'marginRight'                  => '  ',
            'marginBottom'                 => '  ',
            'marginLeft'                   => '  ',
            'paddingTop'                   => '  ',
            'paddingRight'                 => '  ',
            'paddingBottom'                => '  ',
            'paddingLeft'                  => '  ',
            'backgroundColorFrom'          => '  ',
            'backgroundColorTo'            => '  ',
            'gradientDirection'            => '  ',
            'borderTopWidth'               => '  ',
            'borderTopLeftRadius'          => '  ',
            'borderRightWidth'             => '  ',
            'borderTopRightRadius'         => '  ',
            'borderBottomWidth'            => '  ',
            'borderBottomRightRadius'      => '  ',
            'borderLeftWidth'              => '  ',
            'borderBottomLeftRadius'       => '  ',
            'borderColor'                  => '  ',
            'borderStyle'                  => '  ',
            'marginTopHover'               => '  ',
            'marginRightHover'             => '  ',
            'marginBottomHover'            => '  ',
            'marginLeftHover'              => '  ',
            'paddingTopHover'              => '  ',
            'paddingRightHover'            => '  ',
            'paddingBottomHover'           => '  ',
            'paddingLeftHover'             => '  ',
            'backgroundColorFromHover'     => '  ',
            'backgroundColorToHover'       => '  ',
            'gradientDirectionHover'       => '  ',
            'borderTopWidthHover'          => '  ',
            'borderTopLeftRadiusHover'     => '  ',
            'borderRightWidthHover'        => '  ',
            'borderTopRightRadiusHover'    => '  ',
            'borderBottomWidthHover'       => '  ',
            'borderBottomRightRadiusHover' => '  ',
            'borderLeftWidthHover'         => '  ',
            'borderBottomLeftRadiusHover'  => '  ',
            'borderColorHover'             => '  ',
            'borderStyleHover'             => '  ',
            'hasMarginAnimation'           => '  ',
            'hasPaddingAnimation'          => '  ',
            'hasBackgroundAnimation'       => '  ',
            'hasBorderAnimation'           => '  ',
            'width'                        => '  ',
        ];
    }

    /**
     * Data provider for CRUD. Empty values
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
