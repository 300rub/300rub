<?php

namespace ss\tests\unit\models\_abstract\_base;

use ss\models\_abstract\AbstractModel;
use ss\tests\unit\models\_abstract\AbstractModelTest;

/**
 * Abstract class to test base models
 */
abstract class AbstractDuplicateModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return AbstractModel
     */
    abstract protected function getNewModel();

    /**
     * Test duplicate
     *
     * @return void
     */
    abstract public function testDuplicate();

    /**
     * Test Duplicate
     *
     * @param array  $createData        Data to create
     * @param array  $duplicateExpected Expected data after duplication
     * @param string $expectedException Expected exception
     * @param array  $exceptRelations   Except relations
     *
     * @return AbstractDuplicateModelTest
     *
     * @throws \Exception
     */
    protected function duplicate(
        array $createData = [],
        array $duplicateExpected = [],
        $expectedException = null,
        $exceptRelations = []
    ) {
        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        // Create and get model.
        $model = $this->getNewModel()
            ->set($createData)
            ->save();
        $model = $this->getNewModel()
            ->byId($model->getId())
            ->withRelations()
            ->exceptRelations($exceptRelations)
            ->find();

        // Duplicate.
        try {
            $duplicatedModel = $model->duplicate();
        } catch (\Exception $e) {
            $model->delete();
            throw $e;
        }

        $errors = $duplicatedModel->getErrors();
        if (count($errors) > 0) {
            $this->compareExpectedAndActual(
                $duplicateExpected,
                $errors,
                true
            );
            $model->delete();
            return $this;
        }

        // Compare.
        $this->compareExpectedAndActual(
            $duplicateExpected,
            $duplicatedModel->get()
        );
        $this->assertNotSame(
            $model->getId(),
            $duplicatedModel->getId()
        );

        // Read duplicated from DB.
        $duplicatedModel = $this->getNewModel()
            ->byId($duplicatedModel->getId())
            ->withRelations()
            ->exceptRelations($exceptRelations)
            ->find();
        $this->assertInstanceOf(
            "\\ss\\models\\_abstract\\AbstractModel",
            $duplicatedModel
        );
        $this->compareExpectedAndActual(
            $duplicateExpected,
            $duplicatedModel->get()
        );

        // Compare relation IDs.
        $info = $model->getFieldsInfo();
        foreach (array_keys($info) as $field) {
            $hasKey = array_key_exists(
                AbstractModel::FIELD_RELATION,
                $info[$field]
            );
            if ($hasKey === true) {
                $this->assertNotSame(
                    $model->get($field),
                    $duplicatedModel->get($field)
                );
            }

            $hasKey = array_key_exists(
                AbstractModel::FIELD_RELATION_TO_PARENT,
                $info[$field]
            );
            if ($hasKey === true) {
                $this->assertSame(
                    $model->get($field),
                    $duplicatedModel->get($field)
                );
            }
        }

        // Remove.
        $model->delete();
        $duplicatedModel->delete();

        return $this;
    }
}
