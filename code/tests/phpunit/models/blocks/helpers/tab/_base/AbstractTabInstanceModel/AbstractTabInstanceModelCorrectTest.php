<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabInstanceModel;

use ss\models\blocks\helpers\tab\TabGroupModel;
use ss\models\blocks\helpers\tab\TabInstanceModel;
use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractTabInstanceModel
 */
class AbstractTabInstanceModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        $tabGroupModel = new TabGroupModel();
        $tabId = $tabGroupModel->byId(1)->find()->get('tabId');
        $tabModel = new TabModel();
        $tabModel->byId($tabId);
        $tabModel = $tabModel->find();
        $textId = $tabModel->get('textId');

        return [
            'correct1' => [
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
                ],
                [
                    'textInstanceModel' => [
                        'text' => 'new text'
                    ],
                ],
                [
                    'tabGroupId'        => 1,
                    'textInstanceModel' => [
                        'textId' => $textId,
                        'text'   => 'new text'
                    ],
                    'tabTemplateId'     => 1,
                ],
            ]
        ];
    }
}
