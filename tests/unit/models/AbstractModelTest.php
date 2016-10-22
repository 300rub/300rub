<?php

namespace testS\tests\unit\models;

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
        array $updateExpected = []
    )
    {
        // Create
        $model = $this->getModel();
        $model->setFields($createData);
        $model->save();
        if (count($model->getErrors()) > 0) {
            $this->_checkErrors($model, $createErrors);
            return true;
        }

        // Read
        $model = $this->getModel()->byId($model->id)->withRelations()->find();
        $this->_checkValues($model, $createExpected);
        foreach ($model->getRelationsFieldsInfo() as $relationsFieldInfo) {
            $relationModelName = "\\testS\\models\\" . $relationsFieldInfo[AbstractModel::FIELD_RELATION_MODEL];
            $relationFieldName = $relationsFieldInfo[AbstractModel::FIELD_RELATION_NAME];
            $relationType = $relationsFieldInfo[AbstractModel::FIELD_RELATION_TYPE];
            if ($relationType === AbstractModel::FIELD_RELATION_TYPE_BELONGS_TO) {
                $this->assertInstanceOf($relationModelName, $model->$relationFieldName);
            }
        }

        // Update
        $model->setFields($updateData);
        $model->save();
        if (count($model->getErrors()) > 0) {
            $this->_checkErrors($model, $updateErrors);
            return true;
        }

        $this->_checkErrors($model, $updateErrors);
        $this->_checkValues($model, $updateExpected);

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