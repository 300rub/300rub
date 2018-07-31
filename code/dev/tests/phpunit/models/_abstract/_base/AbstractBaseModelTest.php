<?php

namespace ss\tests\phpunit\models\_abstract\_base;

use ss\models\_abstract\AbstractModel;
use ss\tests\phpunit\models\_abstract\AbstractModelTest;

/**
 * Abstract class to test base models
 */
abstract class AbstractBaseModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return AbstractModel
     */
    abstract protected function getNewModel();

    /**
     * Data provider for CRUD
     *
     * @return array
     */
    abstract public function dataProvider();

    /**
     * Test CRUD
     *
     * @param array  $createData      Data to create
     * @param array  $createExpected  Create expected
     * @param array  $updateData      Data to update
     * @param array  $updateExpected  Update expected
     * @param string $createException Expected created exception
     * @param string $updateException Expected update exception
     * @param string $withRelations   With relations
     *
     * @dataProvider dataProvider
     *
     * @return AbstractBaseModelTest
     */
    public function testCreateReadUpdateDelete(
        array $createData = [],
        array $createExpected = [],
        array $updateData = null,
        array $updateExpected = null,
        $createException = null,
        $updateException = null,
        $withRelations = null
    ) {
        // Create.
        if ($createException !== null) {
            $this->expectException($createException);
        }

        $model = $this->getNewModel()->set($createData)->save();
        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $this->compareExpectedAndActual($createExpected, $errors, true);
            return $this;
        }

        if ($withRelations === null) {
            $withRelations = ['*'];
        }

        $this->compareExpectedAndActual($createExpected, $model->get());

        // Read created.
        $model = $this->getNewModel()
            ->byId($model->getId())
            ->withRelations($withRelations)
            ->find();
        $this->assertInstanceOf(
            '\\ss\\models\\_abstract\\AbstractModel',
            $model
        );
        $this->compareExpectedAndActual($createExpected, $model->get());

        // Update.
        if ($updateData !== null) {
            if ($updateException !== null) {
                $this->expectException($updateException);
            }

            $model->set($updateData)->save();

            $errors = $model->getErrors();
            if (count($errors) > 0) {
                $this->compareExpectedAndActual($updateExpected, $errors, true);
                return $this;
            }

            $this->compareExpectedAndActual($updateExpected, $model->get());

            // Read updated.
            $model = $this->getNewModel()
                ->byId($model->getId())
                ->withRelations($withRelations)
                ->find();
            $this->assertInstanceOf(
                '\\ss\\models\\_abstract\\AbstractModel',
                $model
            );
            $this->compareExpectedAndActual(
                $updateExpected,
                $model->get()
            );
        }

        // Delete.
        $model->delete();
        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->assertNull($model);

        return $this;
    }
}
