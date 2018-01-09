<?php

namespace testS\tests\unit\controllers\record;

use testS\models\blocks\block\BlockModel;
use testS\models\blocks\record\RecordModel;
use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateBlockController
 */
class CreateBlockControllerTest extends AbstractControllerTest
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
        $recordCountBefore = RecordModel::model()->getCount();
        $blockCountBefore = BlockModel::model()->getCount();

        $this->setUser($user);
        $this->sendRequest('record', 'block', $data, 'POST');
        $body = $this->getBody();

        $recordCountAfter = RecordModel::model()->getCount();
        $blockModelCountAfter = BlockModel::model()->getCount();

        if ($hasError === true) {
            $this->assertError();

            $this->assertSame($recordCountBefore, $recordCountAfter);
            $this->assertSame($blockCountBefore, $blockModelCountAfter);

            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();

            $this->assertSame(
                $recordCountBefore,
                $recordCountAfter
            );
            $this->assertSame($blockCountBefore, $blockModelCountAfter);

            return true;
        }

        $expected = [
            'result' => true
        ];

        $this->compareExpectedAndActual($expected, $body);

        $blockRecordModel = BlockModel::model()->getLatest();
        $recordModel = $blockRecordModel->getContentModel();

        $this->assertSame(
            $data['name'],
            $blockRecordModel->get('name')
        );
        $this->assertSame(
            $data['hasCover'],
            $recordModel->get('hasCover')
        );
        $this->assertSame(
            $data['hasImages'],
            $recordModel->get('hasImages')
        );
        $this->assertSame(
            $data['hasCoverZoom'],
            $recordModel->get('hasCoverZoom')
        );
        $this->assertSame(
            $data['hasDescription'],
            $recordModel->get('hasDescription')
        );
        $this->assertSame(
            $data['useAutoload'],
            $recordModel->get('useAutoload')
        );
        $this->assertSame(
            $data['pageNavigationSize'],
            $recordModel->get('pageNavigationSize')
        );
        $this->assertSame(
            $data['shortCardDateType'],
            $recordModel->get('shortCardDateType')
        );
        $this->assertSame(
            $data['fullCardDateType'],
            $recordModel->get('fullCardDateType')
        );

        $this->assertSame(
            $recordCountBefore,
            ($recordCountAfter - 1)
        );
        $this->assertSame(
            $blockCountBefore,
            ($blockModelCountAfter - 1)
        );

        $blockRecordModel->delete();

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
            $this->_dataProvider2(),
            $this->_dataProvider3(),
            $this->_dataProvider4()
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
            'userEmptyName'                  => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => '',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => false,
                'hasValidationErrors' => true,
            ],
            'noOperationUser'                => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'data'     => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError' => true,
            ],
            'userWithoutHasCover'                => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectHasCover'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'hasCover'           => 'incorrect',
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutHasImages'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectHasImages'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => 'incorrect',
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
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
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectHasCoverZoom'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => 'incorrect',
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutHasDescription'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectHasDescription'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => 'incorrect',
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutUseAutoload'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
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
    private function _dataProvider3()
    {
        return [
            'userIncorrectUseAutoload'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => 'incorrect',
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutPageNavigationSize'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectPageNavigationSize'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 'incorrect',
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutShortCardDateType'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectShortCardDateType'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 'incorrect',
                    'fullCardDateType'   => 1,
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
    private function _dataProvider4()
    {
        return [
            'userWithoutFullCardDateType'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectFullCardDateType'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 'incorrect',
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userCorrect'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'               => 'Block name',
                    'hasCover'           => true,
                    'hasImages'          => true,
                    'hasCoverZoom'       => true,
                    'hasDescription'     => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 20,
                    'shortCardDateType'  => 1,
                    'fullCardDateType'   => 1,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
        ];
    }
}
