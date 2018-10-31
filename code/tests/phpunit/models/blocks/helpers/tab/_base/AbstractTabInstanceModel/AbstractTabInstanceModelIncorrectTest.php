<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabInstanceModel;

use ss\models\blocks\helpers\tab\TabGroupModel;
use ss\models\blocks\helpers\tab\TabInstanceModel;
use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractTabInstanceModel
 */
class AbstractTabInstanceModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        $tabGroupModel = new TabGroupModel();
        $tabId = $tabGroupModel->byId(1)->find()->get('tabId');
        $tabModel = new TabModel();
        $tabModel->byId($tabId);
        $tabModel = $tabModel->find();
        $textId = $tabModel->get('textId');

        return [
            'incorrect1' => [
                [
                    'tabGroupId'     => 'incorrect',
                    'textInstanceId' => 'incorrect',
                    'tabTemplateId'  => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'tabGroupId'     => 999,
                    'textInstanceId' => 999,
                    'tabTemplateId'  => 999,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'tabGroupId'     => -1,
                    'textInstanceId' => -1,
                    'tabTemplateId'  => -1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect4' => [
                [
                    'tabGroupId'     => '1',
                    'textInstanceModel' => [
                        'textId' => 'incorrect',
                        'text' => ''
                    ],
                    'tabTemplateId'  => ' 1 ',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect5' => [
                [
                    'tabGroupId'     => '1',
                    'textInstanceModel' => [
                        'textId' => $textId,
                    ],
                    'tabTemplateId'  => ' 1 ',
                ],
                [
                    'tabGroupId'        => 1,
                    'textInstanceModel' => [
                        'textId' => $textId,
                        'text'   => ''
                    ],
                    'tabTemplateId'     => 1,
                ],
            ]
        ];
    }
}
