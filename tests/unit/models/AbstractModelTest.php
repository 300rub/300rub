<?php

namespace tests\unit\models;

use models\AbstractModel;
use tests\unit\AbstractUnitTest;

/**
 * Class AbstractModelTest
 *
 * @package tests\unit\models
 */
abstract class AbstractModelTest extends AbstractUnitTest
{

    /**
     * Model object
     *
     * @return AbstractModel
     */
    abstract protected function getModel();

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    abstract public function dataProviderForCRUD();

    /**
     * CRUD
     *
     * @param array $createData
     * @param array $createExpected
     * @param array $createErrors
     * @param array $updateData
     * @param array $updateExpected
     * @param array $updateErrors
     *
     * @dataProvider dataProviderForCRUD
     */
    public function testCRUD(
        $createData,
        $createExpected,
        $createErrors,
        $updateData,
        $updateExpected,
        $updateErrors
    )
    {
        // Create
        $model = $this->getModel();
        $model->setAttributes($createData);
        $this->assertEquals(true, $model->save());
        $this->_checkErrors($model, $createErrors);

        // Read
        $model = $this->getModel()->withAll()->byId($model->id)->find();
        $this->_checkValues($model, $createExpected);

        // Update
        $model->setAttributes($updateData);
        $this->_checkValues($model, $updateExpected);
        $this->_checkErrors($model, $updateErrors);

        // Delete
        $relationKeys = $model->getRelationKeys();
        $this->assertEquals(true, $model->delete());
        foreach ($relationKeys as $key) {
            /**
             * @var AbstractModel $relationModel
             */
            $relationModel = $model->$key;
            $this->assertEquals(null, $relationModel->byId($relationModel->id)->find());
        }
    }

    /**
     * Checks values
     *
     * @param AbstractModel $model
     * @param array         $expected
     *
     * @return AbstractModelTest
     */
    private function _checkValues(AbstractModel $model, $expected)
    {
        foreach ($expected as $key => $value) {
            list($objectName, $field) = explode(AbstractModel::DEFAULT_SEPARATOR, $key);
            if ($objectName === AbstractModel::OBJECT_NAME) {
                $this->assertEquals($value, $model->$field);
            } else {
                $this->assertEquals($value, $model->$objectName->$field);
            }
        }

        return $this;
    }

    /**
     * Checks errors
     *
     * @param AbstractModel $model
     * @param array         $expected
     *
     * @return AbstractModelTest
     */
    private function _checkErrors(AbstractModel $model, $expected)
    {
        $this->assertEquals(count($expected), count($model->errors));
        foreach ($expected as $error) {
            $this->assertEquals(true, array_key_exists($error, $model->errors));
        }
    }
}