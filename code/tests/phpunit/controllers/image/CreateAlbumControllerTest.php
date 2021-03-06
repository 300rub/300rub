<?php

namespace ss\tests\phpunit\controllers\image;

use ss\models\blocks\image\ImageGroupModel;
use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller CreateAlbumController
 */
class CreateAlbumControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user      User type
     * @param array  $data      Data
     * @param bool   $hasError  Error flag
     * @param bool   $hasErrors Errors flag
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun($user, $data, $hasError, $hasErrors)
    {
        $this->setUser($user);

        $this->sendRequest('image', 'album', $data, 'POST');

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        if ($hasErrors === true) {
            $this->assertErrors();
            return true;
        }

        $expected = [
            'result' => true
        ];
        $this->assertSame($expected, $this->getBody());
        ImageGroupModel::model()->latest()->find()->delete();

        return true;
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'limitedEmpty'       => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'blockId'     => 3,
                    'name'        => '',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => false,
                'hasErrors' => true
            ],
            'limitedLongName'    => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'blockId' => 3,
                    'name'        => $this->generateStringWithLength(256),
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => false,
                'hasErrors' => true
            ],
            'limitedCorrect'            => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'blockId'     => 3,
                    'name'        => 'New album name',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => false,
                'hasErrors' => false
            ],
            'limitedIncorrectBlockId'            => [
                'user'      => self::TYPE_LIMITED,
                'data'      => [
                    'blockId'     => 1,
                    'name'        => 'New album name',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => true,
                'hasErrors' => false
            ],
            'noOperation'              => [
                'user'      => self::TYPE_NO_OPERATIONS_USER,
                'data'      => [
                    'blockId'     => 3,
                    'name'        => 'New album name',
                    'alias'       => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'hasError'  => true,
                'hasErrors' => false
            ],
        ];
    }
}
