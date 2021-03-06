<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

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
                    'alias'         => 'alias-1',
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
                    'imageGroupId'      => 1,
                    'originalFileModel' => [
                        'uniqueName' => 'record'
                    ],
                    'viewFileModel'     => [
                        'uniqueName' => 'view_record'
                    ],
                    'thumbFileModel'    => [
                        'uniqueName' => 'thumb_record'
                    ],
                    'isCover'           => false,
                    'sort'              => 0,
                    'alt'               => '',
                    'width'             => 0,
                    'height'            => 0,
                    'viewX'             => 0,
                    'viewY'             => 0,
                    'viewWidth'         => 0,
                    'viewHeight'        => 0,
                    'thumbX'            => 0,
                    'thumbY'            => 0,
                    'thumbWidth'        => 0,
                    'thumbHeight'       => 0,
                ],
                'sort'                         => 0,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
