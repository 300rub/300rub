<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSectionModel;

use ss\models\sections\SectionModel;
use ss\tests\phpunit\models\_abstract\AbstractModelTest;

/**
 * Tests for the model SectionModel
 */
class AbstractSectionModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SectionModel
     */
    protected function getNewModel()
    {
        return new SectionModel();
    }

    /**
     * IsMain test
     *
     * @return void
     */
    public function testIsMain()
    {
        $model = $this->getNewModel()->main()->find();
        if ($model === null) {
            $model = $this->getNewModel();
            $model->set(
                [
                    'seoModel'         => [
                        'name'        => 'name',
                    ],
                    'isMain'           => true
                ]
            );
            $model->save();
        }

        $model = $this->getNewModel()->main()->find();
        $this->assertNotNull($model);

        $newModel = $this->getNewModel();
        $newModel->set(
            [
                'seoModel'         => [
                    'name'        => 'name',
                ],
                'isMain'           => true
            ]
        );
        $newModel->save();

        $this->assertSame(true, $model->get('isMain'));
        $this->assertSame(false, $newModel->get('isMain'));
    }
}