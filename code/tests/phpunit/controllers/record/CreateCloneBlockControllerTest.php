<?php

namespace ss\tests\phpunit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateCloneBlockController
 */
class CreateCloneBlockControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user                User type
     * @param array  $data                Data
     * @param bool   $hasError            Error flag
     * @param bool   $hasValidationErrors Validation errors flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $data,
        $hasError = null,
        $hasValidationErrors = null
    ) {
        $cloneCountBefore = RecordCloneModel::model()->getCount();
        $blockCountBefore = BlockModel::model()->getCount();

        $this->setUser($user);
        $this->sendRequest('record', 'cloneBlock', $data, 'POST');
        $body = $this->getBody();

        $cloneCountAfter = RecordCloneModel::model()->getCount();
        $blockModelCountAfter = BlockModel::model()->getCount();

        if ($hasError === true) {
            $this->assertError();

            $this->assertSame(
                $cloneCountBefore,
                $cloneCountAfter
            );
            $this->assertSame($blockCountBefore, $blockModelCountAfter);

            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();

            $this->assertSame(
                $cloneCountBefore,
                $cloneCountAfter
            );
            $this->assertSame($blockCountBefore, $blockModelCountAfter);

            return true;
        }

        $expected = [
            'result' => true
        ];

        $this->compareExpectedAndActual($expected, $body);

        $blockCloneModel = BlockModel::model()->getLatest();
        $recordCloneModel = $blockCloneModel->getContentModel();

        $this->assertSame(
            $data['name'],
            $blockCloneModel->get('name')
        );
        $this->assertSame(
            $data['hasCover'],
            $recordCloneModel->get('hasCover')
        );
        $this->assertSame(
            $data['hasCoverZoom'],
            $recordCloneModel->get('hasCoverZoom')
        );
        $this->assertSame(
            $data['hasDescription'],
            $recordCloneModel->get('hasDescription')
        );
        $this->assertSame(
            $data['dateType'],
            $recordCloneModel->get('dateType')
        );
        $this->assertSame(
            $data['maxCount'],
            $recordCloneModel->get('maxCount')
        );

        $this->assertSame(
            $cloneCountBefore,
            ($cloneCountAfter - 1)
        );
        $this->assertSame(
            $blockCountBefore,
            ($blockModelCountAfter - 1)
        );

        $blockCloneModel->delete();

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
            'noOperationUser'                    => [
                'user'                => self::TYPE_NO_OPERATIONS_USER,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError' => true,
            ],
            'userEmptyName'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => '',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => false,
                'hasValidationErrors' => true,
            ],
            'userIncorrectRecordBlockId'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 1,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError' => true,
            ],
            'userEmptyRecordBlockId'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 0,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError' => true,
            ],
            'userWithoutHasCover'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectHasCover'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => 'incorrect',
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
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
            'userWithoutHasCoverZoom'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectHasDescription'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => 'incorrect',
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutType'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'maxCount'       => 5,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectMaxCount'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 'incorrect',
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userCorrect'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'recordBlockId'  => 6,
                    'name'           => 'Clone block name',
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
        ];
    }
}
