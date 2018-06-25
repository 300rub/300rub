<?php

namespace ss\tests\unit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

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
        $recordModel = new RecordModel();
        $recordModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => 'name',
                'language'    => 1,
                'contentType' => BlockModel::TYPE_RECORD,
                'contentId'   => $recordModel->getId(),
            ]
        );
        $blockModel->save();

        $data['id'] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest('record', 'block', $data, 'PUT');
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

        $this->assertArrayHasKey('html', $body);
        $this->assertArrayHasKey('css', $body);
        $this->assertArrayHasKey('js', $body);
        $this->assertTrue($body['result']);

        $recordModel = RecordModel::model()
            ->byId($recordModel->getId())
            ->find();
        $blockModel = BlockModel::model()->getById($blockModel->getId());

        $this->assertSame(
            $data['name'],
            $blockModel->get('name')
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
        return [
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
