<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateBlockController
 */
class UpdateBlockControllerTest extends AbstractControllerTest
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
        $imageModel = ImageModel::model()->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => 'name',
                'language'    => 1,
                'contentType' => BlockModel::TYPE_IMAGE,
                'contentId'   => $imageModel->getId(),
            ]
        );
        $blockModel->save();

        $data['id'] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest('image', 'block', $data, 'PUT');
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertError();
            $blockModel->delete();
            return true;
        }

        if ($hasValidationErrors === true) {
            $this->assertErrors();
            $blockModel->delete();
            return true;
        }

        $this->assertTrue($body['result']);

        $imageId = $imageModel->getId();
        $imageModel = ImageModel::model()->byId($imageId)->find();
        $blockModel = $blockModel->getById($blockModel->getId());

        $this->assertSame(
            $data['name'],
            $blockModel->get('name')
        );
        $this->assertSame(
            $data['type'],
            $imageModel->get('type')
        );
        $this->assertSame(
            $data['viewAutoCropType'],
            $imageModel->get('viewAutoCropType')
        );
        $this->assertSame(
            $data['viewCropX'],
            $imageModel->get('viewCropX')
        );
        $this->assertSame(
            $data['viewCropY'],
            $imageModel->get('viewCropY')
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

        $blockModel->delete();

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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewCropX'             => 300,
                    'viewCropY'             => 400,
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
                    'viewAutoCropType'  => 'incorrect',
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
            'userWithoutCropX'               => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'viewAutoCropType'  => 2,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 'incorrect',
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 'incorrect',
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
                    'name'             => 'Block name',
                    'type'             => 1,
                    'viewAutoCropType' => 2,
                    'viewCropX'        => 300,
                    'viewCropY'        => 400,
                    'useAlbums'        => true,
                    'thumbCropX'       => 10,
                    'thumbCropY'       => 20,
                ],
                'hasError'            => true,
                'hasValidationErrors' => false,
            ],
            'userIncorrectThumbAutoCropType' => [
                'user'                => self::TYPE_LIMITED,
                'data'                => [
                    'name'              => 'Block name',
                    'type'              => 1,
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
                    'viewAutoCropType'  => 2,
                    'viewCropX'         => 300,
                    'viewCropY'         => 400,
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
