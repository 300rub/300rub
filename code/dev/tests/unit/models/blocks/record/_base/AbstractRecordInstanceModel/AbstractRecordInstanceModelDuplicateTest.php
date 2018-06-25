<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractRecordInstanceModel
 */
// @codingStandardsIgnoreLine
class AbstractRecordInstanceModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return RecordInstanceModel
     */
    protected function getNewModel()
    {
        return new RecordInstanceModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'recordId'                     => 1,
                'seoModel'                     => [
                    'name'        => 'name 1',
                    'url'         => 'url-1',
                    'title'       => 'title 1',
                    'keywords'    => 'keywords 1',
                    'description' => 'description 1',
                ],
                'textTextInstanceModel'        => [
                    'textId' => 1,
                    'text'   => ''
                ],
                'descriptionTextInstanceModel' => [
                    'textId' => 1,
                    'text'   => ''
                ],
                'imageGroupModel'              => [
                    'imageId' => 1,
                    'seoModel' => [
                        'name' => 'record',
                    ],
                    'sort'    => 0,
                ],
                'coverImageInstanceModel'      => [
                    'imageGroupId' => 1,
                    'originalFileModel' => [
                        'uniqueName' => 'record'
                    ],
                    'viewFileModel' => [
                        'uniqueName' => 'view_record'
                    ],
                    'thumbFileModel' => [
                        'uniqueName' => 'thumb_record'
                    ],
                    'isCover'      => false,
                    'sort'         => 0,
                    'alt'          => '',
                    'width'        => 0,
                    'height'       => 0,
                    'x1'           => 0,
                    'y1'           => 0,
                    'x2'           => 0,
                    'y2'           => 0,
                    'thumbX1'      => 0,
                    'thumbY1'      => 0,
                    'thumbX2'      => 0,
                    'thumbY2'      => 0,
                ],
                'sort'                         => 0,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
