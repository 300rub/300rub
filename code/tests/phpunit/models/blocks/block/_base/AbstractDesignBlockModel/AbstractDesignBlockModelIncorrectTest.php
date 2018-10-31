<?php

namespace ss\tests\phpunit\models\blocks\block\_base\AbstractDesignBlockModel;

use ss\models\blocks\block\DesignBlockModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model DesignBlockModel
 */
class AbstractDesignBlockModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                $this->_createData1(),
                $this->_checkCreateData1(),
                $this->_updateData1(),
                $this->_checkUpdateData1(),
            ],
            'incorrect2' => [
                $this->_createData2(),
                $this->_checkCreateData2(),
                $this->_updateData2(),
                $this->_checkUpdateData2(),
            ],
            'incorrect3' => [
                $this->_createData3(),
                $this->_checkCreateData3(),
                $this->_updateData3(),
                $this->_checkUpdateData3(),
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _createData1()
    {
        return [
            'marginTop'                    => '  10   ',
            'marginRight'                  => '20',
            'marginBottom'                 => '30',
            'marginLeft'                   => '40',
            'paddingTop'                   => '  15  ',
            'paddingRight'                 => '25',
            'paddingBottom'                => '35',
            'paddingLeft'                  => '45',
            'backgroundColorFrom'          => '   rgba(255,255,255,0.5)   ',
            'backgroundColorTo'            => '   rgb(0,0,0)   ',
            'gradientDirection'            => '0',
            'borderTopWidth'               => '1',
            'borderTopLeftRadius'          => '5',
            'borderRightWidth'             => '2',
            'borderTopRightRadius'         => '  10  ',
            'borderBottomWidth'            => ' 3  ',
            'borderBottomRightRadius'      => '15',
            'borderLeftWidth'              => '4',
            'borderBottomLeftRadius'       => '20',
            'borderColor'                  => '  rgba(0,255,255,0.5)  ',
            'borderStyle'                  => '1',
            'marginTopHover'               => '10',
            'marginRightHover'             => '20',
            'marginBottomHover'            => '  30  ',
            'marginLeftHover'              => '40',
            'paddingTopHover'              => '15',
            'paddingRightHover'            => '25',
            'paddingBottomHover'           => '35',
            'paddingLeftHover'             => '45',
            'backgroundColorFromHover'     => '  rgba(255,255,255,0.5)  ',
            'backgroundColorToHover'       => '  rgb(0,0,0)  ',
            'gradientDirectionHover'       => '0',
            'borderTopWidthHover'          => '1',
            'borderTopLeftRadiusHover'     => '5',
            'borderRightWidthHover'        => '2',
            'borderTopRightRadiusHover'    => '10',
            'borderBottomWidthHover'       => '3',
            'borderBottomRightRadiusHover' => '15',
            'borderLeftWidthHover'         => '4',
            'borderBottomLeftRadiusHover'  => '20',
            'borderColorHover'             => ' rgba(0,255,255,0.5) ',
            'borderStyleHover'             => '1',
            'hasMarginAnimation'           => '1',
            'hasPaddingAnimation'          => ' true ',
            'hasBackgroundAnimation'       => 'true',
            'hasBorderAnimation'           => '1',
            'width'                        => '1024',
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _updateData1()
    {
        return [
            'marginTop'                    => 'incorrect type',
            'marginRight'                  => 'incorrect type',
            'marginBottom'                 => 'incorrect type',
            'marginLeft'                   => 'incorrect type',
            'paddingTop'                   => 'incorrect type',
            'paddingRight'                 => 'incorrect type',
            'paddingBottom'                => 'incorrect type',
            'paddingLeft'                  => 'incorrect type',
            'backgroundColorFrom'          => 'incorrect type',
            'backgroundColorTo'            => 'incorrect type',
            'gradientDirection'            => 'incorrect type',
            'borderTopWidth'               => 'incorrect type',
            'borderTopLeftRadius'          => 'incorrect type',
            'borderRightWidth'             => 'incorrect type',
            'borderTopRightRadius'         => 'incorrect type',
            'borderBottomWidth'            => 'incorrect type',
            'borderBottomRightRadius'      => 'incorrect type',
            'borderLeftWidth'              => 'incorrect type',
            'borderBottomLeftRadius'       => 'incorrect type',
            'borderColor'                  => '#cccccc',
            'borderStyle'                  => 'incorrect type',
            'marginTopHover'               => 'incorrect type',
            'marginRightHover'             => 'incorrect type',
            'marginBottomHover'            => 'incorrect type',
            'marginLeftHover'              => 'incorrect type',
            'paddingTopHover'              => 'incorrect type',
            'paddingRightHover'            => 'incorrect type',
            'paddingBottomHover'           => 'incorrect type',
            'paddingLeftHover'             => 'incorrect type',
            'backgroundColorFromHover'     => 'incorrect type',
            'backgroundColorToHover'       => 'incorrect type',
            'gradientDirectionHover'       => 'incorrect type',
            'borderTopWidthHover'          => 'incorrect type',
            'borderTopLeftRadiusHover'     => 'incorrect type',
            'borderRightWidthHover'        => 'incorrect type',
            'borderTopRightRadiusHover'    => 'incorrect type',
            'borderBottomWidthHover'       => 'incorrect type',
            'borderBottomRightRadiusHover' => 'incorrect type',
            'borderLeftWidthHover'         => 'incorrect type',
            'borderBottomLeftRadiusHover'  => 'incorrect type',
            'borderColorHover'             => '0,255,255,0.5',
            'borderStyleHover'             => 'incorrect type',
            'hasMarginAnimation'           => 'incorrect type',
            'hasPaddingAnimation'          => 'incorrect type',
            'hasBackgroundAnimation'       => 'incorrect type',
            'hasBorderAnimation'           => 'incorrect type',
            'width'                        => 'incorrect type',
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _createData2()
    {
        return [
            'marginTop'                    => -301,
            'marginRight'                  => -400,
            'marginBottom'                 => -500,
            'marginLeft'                   => -600,
            'paddingTop'                   => -1,
            'paddingRight'                 => -1,
            'paddingBottom'                => -1,
            'paddingLeft'                  => -1,
            'backgroundColorFrom'          => '#ccc',
            'backgroundColorTo'            => '#cccccc',
            'gradientDirection'            => 99,
            'borderTopWidth'               => -1,
            'borderTopLeftRadius'          => -1,
            'borderRightWidth'             => -1,
            'borderTopRightRadius'         => -1,
            'borderBottomWidth'            => -1,
            'borderBottomRightRadius'      => -1,
            'borderLeftWidth'              => -1,
            'borderBottomLeftRadius'       => -1,
            'borderColor'                  => '0,255,255',
            'borderStyle'                  => 99,
            'marginTopHover'               => -301,
            'marginRightHover'             => -400,
            'marginBottomHover'            => -500,
            'marginLeftHover'              => -600,
            'paddingTopHover'              => -1,
            'paddingRightHover'            => -1,
            'paddingBottomHover'           => -1,
            'paddingLeftHover'             => -1,
            'backgroundColorFromHover'     => '#ccc',
            'backgroundColorToHover'       => '#cccccc',
            'gradientDirectionHover'       => 99,
            'borderTopWidthHover'          => -1,
            'borderTopLeftRadiusHover'     => -1,
            'borderRightWidthHover'        => -1,
            'borderTopRightRadiusHover'    => -1,
            'borderBottomWidthHover'       => -1,
            'borderBottomRightRadiusHover' => -1,
            'borderLeftWidthHover'         => -1,
            'borderBottomLeftRadiusHover'  => -1,
            'borderColorHover'             => '0,255,255',
            'borderStyleHover'             => 99,
            'hasMarginAnimation'           => 2,
            'hasPaddingAnimation'          => 3,
            'hasBackgroundAnimation'       => 4,
            'hasBorderAnimation'           => 6,
            'width'                        => -10,
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _checkCreateData2()
    {
        return [
            'marginTop'                    => -300,
            'marginRight'                  => -300,
            'marginBottom'                 => -300,
            'marginLeft'                   => -300,
            'paddingTop'                   => 0,
            'paddingRight'                 => 0,
            'paddingBottom'                => 0,
            'paddingLeft'                  => 0,
            'backgroundColorFrom'          => '',
            'backgroundColorTo'            => '',
            'gradientDirection'            => 0,
            'borderTopWidth'               => 0,
            'borderTopLeftRadius'          => 0,
            'borderRightWidth'             => 0,
            'borderTopRightRadius'         => 0,
            'borderBottomWidth'            => 0,
            'borderBottomRightRadius'      => 0,
            'borderLeftWidth'              => 0,
            'borderBottomLeftRadius'       => 0,
            'borderColor'                  => '',
            'borderStyle'                  => 0,
            'marginTopHover'               => -300,
            'marginRightHover'             => -300,
            'marginBottomHover'            => -300,
            'marginLeftHover'              => -300,
            'paddingTopHover'              => 0,
            'paddingRightHover'            => 0,
            'paddingBottomHover'           => 0,
            'paddingLeftHover'             => 0,
            'backgroundColorFromHover'     => '',
            'backgroundColorToHover'       => '',
            'gradientDirectionHover'       => 0,
            'borderTopWidthHover'          => 0,
            'borderTopLeftRadiusHover'     => 0,
            'borderRightWidthHover'        => 0,
            'borderTopRightRadiusHover'    => 0,
            'borderBottomWidthHover'       => 0,
            'borderBottomRightRadiusHover' => 0,
            'borderLeftWidthHover'         => 0,
            'borderBottomLeftRadiusHover'  => 0,
            'borderColorHover'             => '',
            'borderStyleHover'             => 0,
            'hasMarginAnimation'           => true,
            'hasPaddingAnimation'          => true,
            'hasBackgroundAnimation'       => true,
            'hasBorderAnimation'           => true,
            'width'                        => 0,
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _updateData2()
    {
        return [
            'marginTop'                    => '-400',
            'marginRight'                  => '-500',
            'marginBottom'                 => '-600',
            'marginLeft'                   => '-700',
            'paddingTop'                   => '  -1',
            'paddingRight'                 => '-1',
            'paddingBottom'                => '-1 ',
            'paddingLeft'                  => '  -1  ',
            'backgroundColorFrom'          => '0,255,255',
            'backgroundColorTo'            => '0,0,255',
            'gradientDirection'            => '  111',
            'borderTopWidth'               => '-1',
            'borderTopLeftRadius'          => '-1',
            'borderRightWidth'             => '  -1',
            'borderTopRightRadius'         => '-1',
            'borderBottomWidth'            => '-1',
            'borderBottomRightRadius'      => '-1',
            'borderLeftWidth'              => '-1',
            'borderBottomLeftRadius'       => '-1',
            'borderColor'                  => '#cccccc',
            'borderStyle'                  => '111',
            'marginTopHover'               => '-400',
            'marginRightHover'             => '-500',
            'marginBottomHover'            => '-600',
            'marginLeftHover'              => '-700',
            'paddingTopHover'              => '-1',
            'paddingRightHover'            => '-1',
            'paddingBottomHover'           => '-1',
            'paddingLeftHover'             => '-1',
            'backgroundColorFromHover'     => '0,255,255',
            'backgroundColorToHover'       => '0,0,255',
            'gradientDirectionHover'       => '111',
            'borderTopWidthHover'          => '-1',
            'borderTopLeftRadiusHover'     => '-1',
            'borderRightWidthHover'        => '-1',
            'borderTopRightRadiusHover'    => '-1',
            'borderBottomWidthHover'       => '-1',
            'borderBottomRightRadiusHover' => '-1',
            'borderLeftWidthHover'         => '-1',
            'borderBottomLeftRadiusHover'  => '-1',
            'borderColorHover'             => '#cccccc',
            'borderStyleHover'             => 111,
            'hasMarginAnimation'           => ' -1 ',
            'hasPaddingAnimation'          => '-2',
            'hasBackgroundAnimation'       => -3,
            'hasBorderAnimation'           => -5,
            'width'                        => '-1',
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _checkUpdateData2()
    {
        return [
            'marginTop'                    => -300,
            'marginRight'                  => -300,
            'marginBottom'                 => -300,
            'marginLeft'                   => -300,
            'paddingTop'                   => 0,
            'paddingRight'                 => 0,
            'paddingBottom'                => 0,
            'paddingLeft'                  => 0,
            'backgroundColorFrom'          => '',
            'backgroundColorTo'            => '',
            'gradientDirection'            => 0,
            'borderTopWidth'               => 0,
            'borderTopLeftRadius'          => 0,
            'borderRightWidth'             => 0,
            'borderTopRightRadius'         => 0,
            'borderBottomWidth'            => 0,
            'borderBottomRightRadius'      => 0,
            'borderLeftWidth'              => 0,
            'borderBottomLeftRadius'       => 0,
            'borderColor'                  => '',
            'borderStyle'                  => 0,
            'marginTopHover'               => -300,
            'marginRightHover'             => -300,
            'marginBottomHover'            => -300,
            'marginLeftHover'              => -300,
            'paddingTopHover'              => 0,
            'paddingRightHover'            => 0,
            'paddingBottomHover'           => 0,
            'paddingLeftHover'             => 0,
            'backgroundColorFromHover'     => '',
            'backgroundColorToHover'       => '',
            'gradientDirectionHover'       => 0,
            'borderTopWidthHover'          => 0,
            'borderTopLeftRadiusHover'     => 0,
            'borderRightWidthHover'        => 0,
            'borderTopRightRadiusHover'    => 0,
            'borderBottomWidthHover'       => 0,
            'borderBottomRightRadiusHover' => 0,
            'borderLeftWidthHover'         => 0,
            'borderBottomLeftRadiusHover'  => 0,
            'borderColorHover'             => '',
            'borderStyleHover'             => 0,
            'hasMarginAnimation'           => false,
            'hasPaddingAnimation'          => false,
            'hasBackgroundAnimation'       => false,
            'hasBorderAnimation'           => false,
            'width'                        => 0,
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _createData3()
    {
        return [
            'marginTop'                    => [],
            'marginRight'                  => ['value'],
            'marginBottom'                 => ['key' => 'value'],
            'marginLeft'                   => [4],
            'paddingTop'                   => [],
            'paddingRight'                 => ['value'],
            'paddingBottom'                => ['key' => 'value'],
            'paddingLeft'                  => [4],
            'backgroundColorFrom'          => [],
            'backgroundColorTo'            => [4],
            'gradientDirection'            => ['key' => 'value'],
            'borderTopWidth'               => ['value'],
            'borderTopLeftRadius'          => [],
            'borderRightWidth'             => [4],
            'borderTopRightRadius'         => ['value'],
            'borderBottomWidth'            => ['key' => 'value'],
            'borderBottomRightRadius'      => [],
            'borderLeftWidth'              => [4],
            'borderBottomLeftRadius'       => ['key' => 'value'],
            'borderColor'                  => '#cccccc',
            'borderStyle'                  => [4],
            'marginTopHover'               => [],
            'marginRightHover'             => [4],
            'marginBottomHover'            => ['value'],
            'marginLeftHover'              => ['key' => 'value'],
            'paddingTopHover'              => [],
            'paddingRightHover'            => [4],
            'paddingBottomHover'           => ['value'],
            'paddingLeftHover'             => [4],
            'backgroundColorFromHover'     => [],
            'backgroundColorToHover'       => ['key' => 'value'],
            'gradientDirectionHover'       => [4],
            'borderTopWidthHover'          => ['key' => 'value'],
            'borderTopLeftRadiusHover'     => [],
            'borderRightWidthHover'        => [4],
            'borderTopRightRadiusHover'    => ['value'],
            'borderBottomWidthHover'       => ['key' => 'value'],
            'borderBottomRightRadiusHover' => ['value'],
            'borderLeftWidthHover'         => [],
            'borderBottomLeftRadiusHover'  => [4],
            'borderColorHover'             => '0,255,255,0.5',
            'borderStyleHover'             => ['value'],
            'hasMarginAnimation'           => [4],
            'hasPaddingAnimation'          => [],
            'hasBackgroundAnimation'       => [4],
            'hasBorderAnimation'           => ['key' => 'value'],
            'width'                        => [],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _checkCreateData3()
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _updateData3()
    {
        return [
            'marginTop'                    => new \stdClass(),
            'marginRight'                  => new \stdClass(),
            'marginBottom'                 => new \stdClass(),
            'marginLeft'                   => new \stdClass(),
            'paddingTop'                   => new \stdClass(),
            'paddingRight'                 => new \stdClass(),
            'paddingBottom'                => new \stdClass(),
            'paddingLeft'                  => new \stdClass(),
            'backgroundColorFrom'          => new \stdClass(),
            'backgroundColorTo'            => new \stdClass(),
            'gradientDirection'            => new \stdClass(),
            'borderTopWidth'               => new \stdClass(),
            'borderTopLeftRadius'          => new \stdClass(),
            'borderRightWidth'             => new \stdClass(),
            'borderTopRightRadius'         => new \stdClass(),
            'borderBottomWidth'            => new \stdClass(),
            'borderBottomRightRadius'      => new \stdClass(),
            'borderLeftWidth'              => new \stdClass(),
            'borderBottomLeftRadius'       => new \stdClass(),
            'borderColor'                  => new \stdClass(),
            'borderStyle'                  => new \stdClass(),
            'marginTopHover'               => new \stdClass(),
            'marginRightHover'             => new \stdClass(),
            'marginBottomHover'            => new \stdClass(),
            'marginLeftHover'              => new \stdClass(),
            'paddingTopHover'              => new \stdClass(),
            'paddingRightHover'            => new \stdClass(),
            'paddingBottomHover'           => new \stdClass(),
            'paddingLeftHover'             => new \stdClass(),
            'backgroundColorFromHover'     => new \stdClass(),
            'backgroundColorToHover'       => new \stdClass(),
            'gradientDirectionHover'       => new \stdClass(),
            'borderTopWidthHover'          => new \stdClass(),
            'borderTopLeftRadiusHover'     => new \stdClass(),
            'borderRightWidthHover'        => new \stdClass(),
            'borderTopRightRadiusHover'    => new \stdClass(),
            'borderBottomWidthHover'       => new \stdClass(),
            'borderBottomRightRadiusHover' => new \stdClass(),
            'borderLeftWidthHover'         => new \stdClass(),
            'borderBottomLeftRadiusHover'  => new \stdClass(),
            'borderColorHover'             => new \stdClass(),
            'borderStyleHover'             => new \stdClass(),
            'hasMarginAnimation'           => new \stdClass(),
            'hasPaddingAnimation'          => new \stdClass(),
            'hasBackgroundAnimation'       => new \stdClass(),
            'hasBorderAnimation'           => new \stdClass(),
            'width'                        => new \stdClass(),
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _checkUpdateData3()
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
