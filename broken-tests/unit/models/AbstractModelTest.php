<?php

namespace tests\unit\models;

use testS\models\AbstractModel;
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
     * @param array $createErrors
     * @param array $createExpected
     * @param array $updateData
     * @param array $updateErrors
     * @param array $updateExpected
     * @param array $skipRelationsForDelete
     *
     * @dataProvider dataProviderForCRUD
     *
     * @return bool
     */
    public function testCRUD(
        array $createData,
        array $createErrors,
        array $createExpected = [],
        array $updateData = [],
        array $updateErrors = [],
        array $updateExpected = [],
        array $skipRelationsForDelete = []
    )
    {
        // Create
        $model = $this->getModel();
        $model->setAttributes($createData);
        if (!$model->save()) {
            $this->_checkErrors($model, $createErrors);
            return true;
        }
        $this->_checkErrors($model, $createErrors);

        // Read
        $model = $this->getModel()->withAll()->byId($model->id)->find();
        $this->_checkValues($model, $createExpected);
        foreach ($model->getRelations() as $relation => $options) {
            $this->assertInstanceOf($options[0], $model->$relation);
        }

        // Update
        $model->setAttributes($updateData);
        if (!$model->save()) {
            $this->_checkErrors($model, $updateErrors);
            return true;
        }
        $this->_checkErrors($model, $updateErrors);
        $this->_checkValues($model, $updateExpected);

        // Delete
        $relationKeys = $model->getRelationKeys();
        $this->assertEquals(true, $model->delete());
        foreach ($relationKeys as $key) {
            if (in_array($key, $skipRelationsForDelete)) {
                continue;    
            }
            
            /**
             * @var AbstractModel $relationModel
             */
            $relationModel = $model->$key;
            $this->assertEquals(null, $relationModel->byId($relationModel->id)->find());
        }

        return true;
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
        foreach ($expected as $field => $error) {
            $this->assertTrue(array_key_exists($field, $model->errors));
            $this->assertEquals($error, $model->errors[$field]);
        }
    }
}