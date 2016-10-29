<?php

namespace testS\tests\unit\models;

use testS\components\exceptions\ModelException;
use testS\models\AbstractModel;
use testS\tests\unit\AbstractUnitTest;

/**
 * Class AbstractModelTest
 *
 * @package testS\tests\unit\models
 */
abstract class AbstractModelTest extends AbstractUnitTest
{

    /**
     * Exception
     */
    const MODEL_EXCEPTION = "ModelException";

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
     * @param mixed $createExpected
     * @param array $updateData
     * @param mixed $updateExpected
     *
     * @dataProvider dataProviderForCRUD
     *
     * @return bool
     */
    public function testCRUD(array $createData, $createExpected, array $updateData = [], $updateExpected = null)
    {
        // Create
        try {
            $model = $this->getModel();
            $model->setFields($createData);
            $model->save();

            if (count($model->getErrors()) > 0) {
                $this->_checkErrors($model, $createExpected);
                return true;
            }
        } catch (ModelException $e) {
            $this->assertEquals(self::MODEL_EXCEPTION, $createExpected);
            return true;
        }

        // Read created
        $this->_read($model->id, $createExpected);

        // Update
        try {
            $model->setFields($updateData);
            $model->save();
            if (count($model->getErrors()) > 0) {
                $this->_checkErrors($model, $updateExpected);
                return true;
            }

            $this->_checkValues($model, $updateExpected);
        } catch (ModelException $e) {
            $this->assertEquals(self::MODEL_EXCEPTION, $updateExpected);
            return true;
        }

        // Read updated
        $this->_read($model->id, $updateExpected);

        // Delete
        $model->delete();
        $this->assertNull($this->getModel()->byId($model->id)->find());
        /**
         * @var AbstractModel $relationModel
         */
        foreach ($model->getRelationsFieldsInfo() as $field => $relationsFieldInfo) {
            $relationModelName = "\\testS\\models\\" . $relationsFieldInfo[AbstractModel::FIELD_RELATION_MODEL];
            $relationModel = new $relationModelName;
            $relationType = $relationsFieldInfo[AbstractModel::FIELD_RELATION_TYPE];
            if ($relationType === AbstractModel::FIELD_RELATION_TYPE_BELONGS_TO) {
                $this->assertNull($relationModel->byId($model->$field)->find());
            }
        }

        return true;
    }

    /**
     * Reads a record by ID and verifies values
     *
     * @param int   $id
     * @param array $expected
     */
    private function _read($id, array $expected)
    {
        $model = $this->getModel()->byId($id)->withRelations()->find();
        $this->_checkValues($model, $expected);
        foreach ($model->getRelationsFieldsInfo() as $relationsFieldInfo) {
            $relationModelName = "\\testS\\models\\" . $relationsFieldInfo[AbstractModel::FIELD_RELATION_MODEL];
            $relationFieldName = $relationsFieldInfo[AbstractModel::FIELD_RELATION_NAME];
            $relationType = $relationsFieldInfo[AbstractModel::FIELD_RELATION_TYPE];
            if ($relationType === AbstractModel::FIELD_RELATION_TYPE_BELONGS_TO) {
                $this->assertInstanceOf($relationModelName, $model->$relationFieldName);
            }
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
            if (is_array($value)) {
                $this->_checkValues($model->$key, $value);
            } else {
                $this->assertEquals(
                    $value,
                    $model->$key,
                    "For field \"{$key}\""
                );
            }
        }

        return $this;
    }

    /**
     * Checks errors
     *
     * @param AbstractModel $model
     * @param array         $expected
     */
    private function _checkErrors(AbstractModel $model, $expected)
    {
        $this->assertEquals(count($expected), count($model->getErrors()));
        foreach ($expected as $field => $errors) {
            $errorList = implode(",", array_keys($model->getErrors()));
            $this->assertTrue(array_key_exists($field, $model->getErrors()), "Unable to find the error \"{$field}\" in error list: \"{$errorList}\" ");
            $this->assertEquals($errors, $model->getErrors()[$field]);
        }
    }
}