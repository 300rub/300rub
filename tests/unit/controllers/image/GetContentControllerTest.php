<?php

namespace testS\tests\unit\controllers\image;

use testS\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetContentController
 */
class GetContentControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user     User type
     * @param int    $blockId  Block ID
     * @param bool   $hasError Error flag
     * @param array  $expected Expected result
     * @param int    $groupId  Group ID
     *
     * @dataProvider dataProvider
     *
     * @return bool
     */
    public function testRun(
        $user,
        $blockId,
        $hasError,
        $expected,
        $groupId = null
    ) {
        $this->setUser($user);

        $data = [
            'id' => $blockId
        ];
        if ($groupId !== null) {
            $data['groupId'] = $groupId;
        }

        $this->sendRequest('image', 'content', $data);

        if ($hasError === true) {
            $this->assertError();
            return true;
        }

        $this->compareExpectedAndActual($expected, $this->getBody());

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
            'userCorrectAlbums' => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 5,
                'hasError' => false,
                'expected' => [
                    'labels'         => [],
                    'useAlbums'      => true,
                    'canCreateAlbum' => true,
                    'canUpdateAlbum' => true,
                    'canDeleteAlbum' => true,
                    'list'           => [
                        [
                            'id'    => 4,
                            'name'  => 'Name 1',
                            'cover' => []
                        ],
                        [
                            'id'    => 5,
                            'name'  => 'Name 2',
                            'cover' => null
                        ]
                    ]
                ]
            ],
            'userCorrectAlbum' => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 5,
                'hasError' => false,
                'expected' => [
                    'labels'         => [],
                    'useAlbums'      => false,
                    'canUploadImage' => true,
                    'canUpdateImage' => true,
                    'canDeleteImage' => true,
                    'list'           => [
                        [
                            'id'  => 3,
                            'alt' => '',
                        ],
                        [
                            'id'  => 4,
                            'alt' => '',
                        ]
                    ]
                ],
                'groupId'  => 4,
            ],
            'userCorrectWithoutAlbums' => [
                'user' => self::TYPE_LIMITED,
                'blockId'  => 3,
                'hasError' => false,
                'expected' => []
            ],
            'userIncorrectBlock' => [
                'user'     => self::TYPE_LIMITED,
                'blockId'  => 1,
                'hasError' => true,
                'expected' => [
                    'labels'         => [],
                    'useAlbums'      => false,
                    'canUploadImage' => true,
                    'canUpdateImage' => true,
                    'canDeleteImage' => true,
                    'list'           => [
                        [
                            'id'  => 1,
                            'alt' => '',
                        ],
                        [
                            'id'  => 2,
                            'alt' => '',
                        ]
                    ]
                ]
            ],
            'withoutOperations'  => [
                'user'     => self::TYPE_NO_OPERATIONS_USER,
                'blockId'  => 5,
                'hasError' => true,
                'expected' => []
            ]
        ];
    }
}