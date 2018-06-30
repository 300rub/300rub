<?php

namespace ss\tests\unit\controllers\record;

use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetCloneBlockController
 */
class GetCloneBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user          User type
     * @param int    $recordBlockId Record Block ID
     * @param int    $blockId       Block ID
     * @param bool   $hasError      Error flag
     * @param array  $expected      Expected data
     * @param bool   $hasImages     Has images flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $recordBlockId,
        $blockId,
        $hasError,
        array $expected = [],
        $hasImages = null
    ) {
        $this->setUser($user);
        $this->sendRequest(
            'record',
            'cloneBlock',
            [
                'recordBlockId' => $recordBlockId,
                'id'            => $blockId,
            ]
        );
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $expectedResult = [
            'id'    => $blockId,
            'title' => $expected['title'],
            'forms' => [
                'name'               => [
                    'name'       => 'name',
                    'validation' => [],
                    'value'      => $expected['name'],
                ],
                'hasDescription' => [
                    'name'       => 'hasDescription',
                    'value'      => $expected['hasDescription'],
                ],
                'dateType'  => [
                    'value' => $expected['dateType'],
                    'name'  => 'dateType',
                    'list'  => []
                ],
                'maxCount' => [
                    'name'  => 'maxCount',
                    'value' => $expected['maxCount'],
                ],
                'button'             => [
                    'label' => $expected['button'],
                ],
            ]
        ];

        $this->compareExpectedAndActual($expectedResult, $body);

        if ($hasImages !== true) {
            $this->assertArrayNotHasKey('hasCover', $body['forms']);
            $this->assertArrayNotHasKey('hasCoverZoom', $body['forms']);
            return true;
        }

        $expectedResult = [
            'forms' => [
                'hasCover'     => [
                    'name'  => 'hasCover',
                    'value' => $expected['hasCover'],
                ],
                'hasCoverZoom' => [
                    'value' => $expected['hasCoverZoom'],
                    'name'  => 'hasCoverZoom',
                ],
            ]
        ];

        $this->compareExpectedAndActual($expectedResult, $body);

        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return array_merge(
            $this->_dataProvider1(),
            $this->_dataProvider2()
        );
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProvider1()
    {
        return [
            'user67' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'blockId'       => 7,
                'hasError'      => false,
                'expected'      => [
                    'title'          => 'Edit record clone',
                    'name'           => 'Records 1 clone 1',
                    'hasDescription' => false,
                    'dateType'       => 0,
                    'maxCount'       => 2,
                    'button'         => 'Update',
                ],
                false
            ],
            'user69' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'blockId'       => 9,
                'hasError'      => false,
                'expected'      => [
                    'title'          => 'Edit record clone',
                    'name'           => 'Records 1 clone 2',
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 3,
                    'button'         => 'Update',
                ],
                false
            ],
            'user810' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 8,
                'blockId'       => 10,
                'hasError'      => false,
                'expected'      => [
                    'title'          => 'Edit record clone',
                    'name'           => 'Records 2 clone 1',
                    'hasDescription' => false,
                    'dateType'       => 0,
                    'maxCount'       => 4,
                    'button'         => 'Update',
                    'hasCover'       => false,
                    'hasCoverZoom'   => false,
                ],
                true
            ],
            'user811' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 8,
                'blockId'       => 11,
                'hasError'      => false,
                'expected'      => [
                    'title'          => 'Edit record clone',
                    'name'           => 'Records 2 clone 2',
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                    'button'         => 'Update',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                ],
                true
            ],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    private function _dataProvider2()
    {
        return [
            'user6New' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'blockId'       => 0,
                'hasError'      => false,
                'expected'      => [
                    'title'          => 'Add record clone',
                    'name'           => '',
                    'hasDescription' => false,
                    'dateType'       => 0,
                    'maxCount'       => 0,
                    'button'         => 'Add',
                ],
                false
            ],
            'user8New' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 8,
                'blockId'       => 0,
                'hasError'      => false,
                'expected'      => [
                    'title'          => 'Add record clone',
                    'name'           => '',
                    'hasDescription' => false,
                    'dateType'       => 0,
                    'maxCount'       => 0,
                    'button'         => 'Add',
                    'hasCover'       => false,
                    'hasCoverZoom'   => false,
                ],
                true
            ],
            'noOperationAdd'   => [
                'user'          => self::TYPE_NO_OPERATIONS_USER,
                'recordBlockId' => 6,
                'blockId'       => 0,
                'hasError'      => true
            ],
            'noOperationEdit7' => [
                'user'          => self::TYPE_NO_OPERATIONS_USER,
                'recordBlockId' => 6,
                'blockId'       => 7,
                'hasError'      => true,
            ],
            'userIncorrectRecordBlockId' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'blockId'       => 11,
                'hasError'      => true
            ],
            'userEmptyRecordBlockId' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 0,
                'blockId'       => 11,
                'hasError'      => true
            ],
            'userRecordBlockIdNotExist' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 9999,
                'blockId'       => 11,
                'hasError'      => true
            ],
            'userRecordCloneBlockIdNotExist' => [
                'user'          => self::TYPE_LIMITED,
                'recordBlockId' => 6,
                'blockId'       => 99999999,
                'hasError'      => true
            ],
        ];
    }
}
