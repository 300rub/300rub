<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\tab\_base\AbstractTabInstanceModel;

use testS\models\blocks\helpers\tab\TabGroupModel;
use testS\models\blocks\helpers\tab\TabInstanceModel;
use testS\models\blocks\helpers\tab\TabModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractTabInstanceModel
 */
class AbstractTabInstanceModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return TabInstanceModel
     */
    protected function getNewModel()
    {
        return new TabInstanceModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $tabGroupModel = new TabGroupModel();
        $tabId = $tabGroupModel->byId(1)->find()->get('tabId');
        $tabModel = new TabModel();
        $tabModel->byId($tabId);
        $tabModel = $tabModel->find();
        $textId = $tabModel->get('textId');

        $this->duplicate(
            [
                'tabGroupId'        => 1,
                'textInstanceModel' => [
                    'textId' => $textId,
                    'text'   => 'text...'
                ],
                'tabTemplateId'     => 1,
            ],
            [
                'tabGroupId'        => 1,
                'textInstanceModel' => [
                    'textId' => $textId,
                    'text'   => 'text...'
                ],
                'tabTemplateId'     => 1,
            ]
        );
    }
}
