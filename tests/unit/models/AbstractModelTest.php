<?php

namespace testS\tests\unit\models;

use testS\components\exceptions\ModelException;
use testS\components\ValueGenerator;
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
            $this->assertEquals(self::MODEL_EXCEPTION, $createExpected, $e->getMessage());
            return true;
        }

        // Read created
        $model = $this->_read($model->id, $createExpected);

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
            $this->assertEquals(self::MODEL_EXCEPTION, $updateExpected, $e->getMessage());
            return true;
        }

        // Read updated
        $model = $this->_read($model->id, $updateExpected);

        // Delete
        $model->delete();
        $this->assertNull($this->getModel()->byId($model->id)->find());
        /**
         * @var AbstractModel $relationModel
         */
        foreach ($model->getRelationsFieldsInfo() as $field => $relationsFieldInfo) {
            $relationModelName = "\\testS\\models\\" . $relationsFieldInfo[0];
            $relationModel = new $relationModelName;
            $this->assertNull($relationModel->byId($model->$field)->find());
        }

        // Duplicate
        $duplicateModel = $model->duplicate();
        $this->_compareTwoModelsAfterDuplicate($model, $duplicateModel);
        $duplicateModel->delete();

        return true;
    }

    /**
     * Checks two models
     *
     * @param AbstractModel $model
     * @param AbstractModel $duplicateModel
     */
    private function _compareTwoModelsAfterDuplicate($model, $duplicateModel)
    {
        $this->assertNotEquals($model->id, $duplicateModel->id);

        foreach ($model->getFieldsInfo() as $field => $info) {
            if (array_key_exists(AbstractModel::FIELD_RELATION, $info)) {
                $relationName = substr($field, 0, -2) . "Model";
                $this->_compareTwoModelsAfterDuplicate($model->$relationName, $duplicateModel->$relationName);
                continue;
            }

            if (array_key_exists(AbstractModel::FIELD_SKIP_DUPLICATION, $info)) {
                $this->assertFalse(!!$duplicateModel->$field);
                continue;
            }

            if (!array_key_exists(AbstractModel::FIELD_CHANGE_ON_DUPLICATE, $info)) {
                $this->assertEquals($model->$field, $duplicateModel->$field);
                continue;
            }

            foreach ($info[AbstractModel::FIELD_CHANGE_ON_DUPLICATE] as $key => $value) {
                if (is_string($key)) {
                    if (is_string($value)) {
                        if (stripos($value, "{") === 0) {
                            $value = str_replace(["{", "}"], "", $value);
                            $value = $model->$value;
                        }
                    }

                    if (is_array($value)) {
                        foreach ($value as &$val) {
                            if (is_string($val)) {
                                if (stripos($val, "{") === 0) {
                                    $val = str_replace(["{", "}"], "", $val);
                                    $val = $model->$val;
                                }
                            }
                        }
                    }

                    $this->assertEquals(
                        ValueGenerator::$key($model->$field, $value),
                        $duplicateModel->$field
                    );
                } else {
                    $this->assertEquals(
                        ValueGenerator::$value($model->$field),
                        $duplicateModel->$field
                    );
                }
            }
        }
    }

    /**
     * Reads a record by ID and verifies values
     *
     * @param int   $id
     * @param array $expected
     *
     * @return AbstractModel
     */
    private function _read($id, array $expected)
    {
        $model = $this->getModel()->byId($id)->withRelations()->find();
        $this->_checkValues($model, $expected);
        foreach ($model->getRelationsFieldsInfo() as $relationsFieldInfo) {
            $relationModelName = "\\testS\\models\\" . $relationsFieldInfo[0];
            $relationFieldName = $relationsFieldInfo[1];
            $this->assertInstanceOf($relationModelName, $model->$relationFieldName);
        }

        return $model;
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
            $this->assertTrue(
                array_key_exists($field, $model->getErrors()),
                "Unable to find the error \"{$field}\" in error list: \"{$errorList}\""
            );
            $this->assertEquals($errors, $model->getErrors()[$field]);
        }
    }
}