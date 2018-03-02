<?php

namespace ss\tests\unit\controllers\record;

use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller UpdateCloneBlockController
 */
class UpdateCloneBlockControllerTest extends AbstractControllerTest
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
        $recordCloneModel = new RecordCloneModel();
        $recordCloneModel->set(['recordId' => $data['recordId']]);
        $recordCloneModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => 'name',
                'language'    => 1,
                'contentType' => BlockModel::TYPE_RECORD_CLONE,
                'contentId'   => $recordCloneModel->getId(),
            ]
        );
        $blockModel->save();

        $data['id'] = $blockModel->getId();

        $this->setUser($user);
        $this->sendRequest('record', 'cloneBlock', $data, 'PUT');
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

        $recordCloneModel = RecordCloneModel::model()
            ->byId($recordCloneModel->getId())
            ->find();
        $blockModel = BlockModel::model()->getById($blockModel->getId());

        $this->assertSame(
            $data['name'],
            $blockModel->get('name')
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
                    'name'           => 'Block clone name',
                    'recordBlockId'  => 6,
                    'recordId'       => 1,
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError' => true,
            ],
            'userCorrect'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'     => [
                    'name'           => 'Block clone name',
                    'recordBlockId'  => 6,
                    'recordId'       => 1,
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => false,
                'hasValidationErrors' => false,
            ],
            'userEmptyName'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'     => [
                    'name'           => '',
                    'recordBlockId'  => 6,
                    'recordId'       => 1,
                    'hasCover'       => true,
                    'hasCoverZoom'   => true,
                    'hasDescription' => true,
                    'dateType'       => 1,
                    'maxCount'       => 5,
                ],
                'hasError'            => false,
                'hasValidationErrors' => true,
            ],
            'userEmptyRecordBlockId'                    => [
                'user'                => self::TYPE_LIMITED,
                'data'     => [
                    'name'           => 'Block clone name',
                    'recordId'       => 1,
                    'hasCover'       => true,
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
}
