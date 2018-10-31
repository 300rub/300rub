<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabTemplateModel;

use ss\models\blocks\helpers\tab\TabTemplateModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractTabTemplateModel
 */
class AbstractTabTemplateModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return TabTemplateModel
     */
    protected function getNewModel()
    {
        return new TabTemplateModel();
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'tabId' => 1,
                    'sort'  => 10,
                    'label' => 'Label',
                ],
                [
                    'tabId' => 1,
                    'sort'  => 10,
                    'label' => 'Label',
                ],
                [
                    'tabId' => 1,
                    'sort'  => 20,
                    'label' => 'New label',
                ],
                [
                    'tabId' => 1,
                    'sort'  => 20,
                    'label' => 'New label',
                ],
            ]
        ];
    }
}
