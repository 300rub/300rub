<?php

namespace ss\tests\phpunit\controllers\image;

use ss\tests\phpunit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetBlocksController
 */
class GetBlocksControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @param string $user              User type
     * @param int    $blockSection      Block section
     * @param bool   $hasError          Error flag
     * @param bool   $hasResult         Results flag
     * @param bool   $canAdd            Add ability flag
     * @param bool   $canUpdateDesign   Update design ability flag
     * @param bool   $catUpdateContent  UpdateContent ability flag
     * @param bool   $canUpdateSettings Update settings ability flag
     *
     * @return bool
     *
     * @dataProvider dataProvider
     */
    public function testRun(
        $user,
        $blockSection,
        $hasError,
        $hasResult = null,
        $canAdd = null,
        $canUpdateDesign = null,
        $catUpdateContent = null,
        $canUpdateSettings = null
    ) {
        $this->setUser($user);
        $this->sendRequest(
            'image',
            'blocks',
            [
                'blockSection' => $blockSection
            ]
        );
        $body = $this->getBody();

        if ($hasError === true) {
            $this->assertArrayHasKey('error', $body);
            return true;
        }

        $this->assertTrue(strlen($body['title']) > 0);
        $this->assertTrue(strlen($body['description']) > 0);
        $this->assertSame('block', $body['back']['controller']);
        $this->assertSame('blocks', $body['back']['action']);
        $this->assertSame('image', $body['settings']['controller']);
        $this->assertSame('block', $body['settings']['action']);
        $this->assertSame('image', $body['design']['controller']);
        $this->assertSame('design', $body['design']['action']);
        $this->assertSame('image', $body['content']['controller']);
        $this->assertSame('content', $body['content']['action']);

        $this->assertSame($canAdd, $body['canAdd']);

        if ($hasResult === false) {
            $this->assertSame(0, count($body['list']));
            return true;
        }

        $this->assertTrue(count($body['list']) > 0);

        foreach ($body['list'] as $item) {
            $this->assertTrue(strlen($item['name']) > 0);
            $this->assertTrue($item['id'] > 0);
            $this->assertSame($canUpdateSettings, $item['canUpdateSettings']);
            $this->assertSame($canUpdateDesign, $item['canUpdateDesign']);
            $this->assertSame($catUpdateContent, $item['canUpdateContent']);
        }

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
            'limitedViewAll'                 => [
                'user'                     => self::TYPE_LIMITED,
                'blockSection' => 0,
                'hasError'                 => false,
                'hasResult'                => true,
                'canAdd'                   => true,
                'canUpdateDesign'          => true,
                'catUpdateContent'         => true,
                'canUpdateSettings'        => true,
            ],
            'limitedViewFromPage'            => [
                'user'                     => self::TYPE_LIMITED,
                'blockSection' => 1,
                'hasError'                 => false,
                'hasResult'                => true,
                'canAdd'                   => true,
                'canUpdateDesign'          => true,
                'catUpdateContent'         => true,
                'canUpdateSettings'        => true,
            ],
            'limitedViewFromNonexistentPage' => [
                'user'                     => self::TYPE_LIMITED,
                'blockSection' => 9999,
                'hasError'                 => false,
                'hasResult'                => false,
                'canAdd'                   => true,
            ],
            'noOperationViewAll'             => [
                'user'                     => self::TYPE_NO_OPERATIONS_USER,
                'blockSection' => 0,
                'hasError'                 => false,
                'hasResult'                => false,
                'canAdd'                   => false,
            ],
        ];
    }
}
