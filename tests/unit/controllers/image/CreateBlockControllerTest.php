<?php

namespace testS\tests\unit\controllers\image;

use testS\models\blocks\block\BlockModel;
use testS\models\blocks\image\ImageModel;
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
        $imageCountBefore = ImageModel::model()->getCount();
        $blockCountBefore = BlockModel::model()->getCount();

        $this->setUser($user);
        $this->sendRequest('image', 'block', $data, 'POST');
        $body = $this->getBody();

        $imageModelCountAfter = ImageModel::model()->getCount();
        $blockModelCountAfter = BlockModel::model()->getCount();

        if ($hasError === true) {
            $this->assertError();
            $this->assertSame($imageCountBefore, $imageModelCountAfter);
            $this->assertSame($blockCountBefore, $blockModelCountAfter);
            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();
            $this->assertSame($imageCountBefore, $imageModelCountAfter);
            $this->assertSame($blockCountBefore, $blockModelCountAfter);
            return true;
        }

        $expected = ['result' => true];

        $this->compareExpectedAndActual($expected, $body);

        $blockImageModel = BlockModel::model()->getLatest();
        $imageModel = $blockImageModel->getContentModel();

        $this->assertSame(
            $data['name'],
            $blockImageModel->get('name')
        );
        $this->assertSame(
            $data['type'],
            $imageModel->get('type')
        );
        $this->assertSame(
            $data['autoCropType'],
            $imageModel->get('autoCropType')
        );
        $this->assertSame(
            $data['cropWidth'],
            $imageModel->get('cropWidth')
        );
        $this->assertSame(
            $data['cropHeight'],
            $imageModel->get('cropHeight')
        );
        $this->assertSame(
            $data['cropX'],
            $imageModel->get('cropX')
        );
        $this->assertSame(
            $data['cropY'],
            $imageModel->get('cropY')
        );
        $this->assertSame(
            $data['thumbAutoCropType'],
            $imageModel->get('thumbAutoCropType')
        );
        $this->assertSame(
            $data['useAlbums'],
            $imageModel->get('useAlbums')
        );
        $this->assertSame(
            $data['thumbCropX'],
            $imageModel->get('thumbCropX')
        );
        $this->assertSame(
            $data['thumbCropY'],
            $imageModel->get('thumbCropY')
        );

        $this->assertSame($imageCountBefore, ($imageModelCountAfter - 1));
        $this->assertSame($blockCountBefore, ($blockModelCountAfter - 1));

        $blockImageModel->delete();
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
            $this->_dataProvider4(),
            $this->_dataProvider5(),
            $this->_dataProvider6()
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
            'fullCorrect'                    => [
                'user'                => self::TYPE_FULL,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
            'fullEmptyName'                  => [
                'user'                => self::TYPE_FULL,
                'data'                => [
                    'name'              => '',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => false,
                'hasValidationErrors' => true,
            ],
            'guest'                          => [
                'user'     => null,
                'data'     => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError' => true,
            ],
            'blocked'                        => [
                'user'     => self::TYPE_BLOCKED_USER,
                'data'     => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError' => true,
            ],
            'noOperationUser'                => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'data'     => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError' => true,
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
            'userWithoutType'                => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectType'              => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 'incorrect',
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutAutoCropType'        => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectAutoCropType'      => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 'incorrect',
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutCropWidth'           => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
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
            'userIncorrectCropWidth'         => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 'incorrect',
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutCropHeight'          => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectCropHeight'        => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 'incorrect',
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutCropX'               => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectCropX'             => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 'incorrect',
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
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
            'userWithoutCropY'               => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectCropY'             => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 'incorrect',
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutThumbAutoCropType'   => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'         => 'Block name',
                    'type'         => 1,
                    'autoCropType' => 2,
                    'cropWidth'    => 100,
                    'cropHeight'   => 200,
                    'cropX'        => 300,
                    'cropY'        => 400,
                    'useAlbums'    => true,
                    'thumbCropX'   => 10,
                    'thumbCropY'   => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectThumbAutoCropType' => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 'incorrect',
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutUseAlbums'           => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
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
    private function _dataProvider5()
    {
        return [
            'userIncorrectUseAlbums'         => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => 'incorrect',
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutThumbCropX'          => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectThumbCropX'        => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 'incorrect',
                    'thumbCropY'        => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userWithoutThumbCropY'          => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 20,
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
    private function _dataProvider6()
    {
        return [
            'userIncorrectThumbCropY'        => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 'incorrect',
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userCorrect'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'autoCropType'      => 2,
                    'cropWidth'         => 100,
                    'cropHeight'        => 200,
                    'cropX'             => 300,
                    'cropY'             => 400,
                    'thumbAutoCropType' => 3,
                    'useAlbums'         => true,
                    'thumbCropX'        => 10,
                    'thumbCropY'        => 20,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
        ];
    }
}
