<?php

namespace ss\tests\phpunit\controllers\image;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

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
            'blockId' => $blockId
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
                    'labels'    => [],
                    'useAlbums' => true,
                    'canCreate' => true,
                    'canUpdate' => true,
                    'canDelete' => true,
                    'list'      => [
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
        ];
    }
}
