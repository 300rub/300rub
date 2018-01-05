<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextModel;

use testS\models\blocks\text\TextInstanceModel;
use testS\models\blocks\text\TextModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model TextModel
 */
class AbstractTextModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $modelForCopy = $this->getNewModel()->byId(1)->find();
        $duplicatedModel = $modelForCopy->duplicate();

        $this->assertNotSame(
            $modelForCopy->getId(),
            $duplicatedModel->getId()
        );
        $this->assertNotSame(
            $modelForCopy->get('designTextId'),
            $duplicatedModel->get('designTextId')
        );
        $this->assertNotSame(
            $modelForCopy->get('designBlockId'),
            $duplicatedModel->get('designBlockId')
        );
        $this->assertSame(
            $modelForCopy->get('type'),
            $duplicatedModel->get('type')
        );
        $this->assertSame(
            $modelForCopy->get('hasEditor'),
            $duplicatedModel->get('hasEditor')
        );

        $textInstanceModel = new TextInstanceModel();
        $instancesForCopy = $textInstanceModel
            ->byTextId($modelForCopy->getId())
            ->findAll();
        $textInstanceModel = new TextInstanceModel();
        $duplicatedInstances = $textInstanceModel
            ->byTextId($duplicatedModel->getId())
            ->findAll();
        $this->assertSame(
            count($instancesForCopy),
            count($duplicatedInstances)
        );

        foreach ($instancesForCopy as $key => $instanceForCopy) {
            $this->assertSame(
                $modelForCopy->getId(),
                $instanceForCopy->get('textId')
            );

            $duplicatedText = $duplicatedInstances[$key];
            $this->assertSame(
                $duplicatedModel->getId(),
                $duplicatedText->get('textId')
            );

            $this->assertSame(
                $instanceForCopy->get('text'),
                $duplicatedText->get('text')
            );
        }

        $duplicatedModel->delete();
        foreach ($duplicatedInstances as $duplicatedInstance) {
            $textInstanceModel = new TextInstanceModel();
            $this->assertNull(
                $textInstanceModel
                    ->byId($duplicatedInstance->getId())
                    ->find()
            );
        }
    }
}
