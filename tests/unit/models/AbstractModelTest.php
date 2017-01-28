<?php

namespace testS\tests\unit\models;

use testS\components\Db;
use testS\components\Validator;
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
     * Model object
     *
     * @return string
     */
    abstract protected function getModelName();

    /**
     * DB Table structure test
     */
    public function testTableStructure()
    {
        $modelName = sprintf("\\testS\\models\\%s", $this->getModelName());

        /**
         * @var AbstractModel $model
         */
        $model = new $modelName;
        $describeInfoList = Db::fetchAll(sprintf("DESCRIBE %s", $model->getTableName()));
//        foreach ($describeInfoList as $describeInfo) {
//            $this->assertTrue(
//                property_exists($model, $describeInfo["Field"]),
//                sprintf(
//                    "Unable to find property [%s] for model [%s]",
//                    $describeInfo["Field"],
//                    $this->getModelName()
//                )
//            );
//        }

        $modelInfoList = $model->getFieldsInfo();
        foreach ($modelInfoList as $modelField => $modelInfo) {
            $describeKey = null;
            foreach ($describeInfoList as $key => $describeInfo) {
                if ($modelField === $describeInfo["Field"]) {
                    $describeKey = $key;
                    break;
                }
            }

            $this->assertNotNull(
                $describeKey,
                sprintf(
                    "Unable to find field [%s] from table [%s]",
                    $modelField,
                    $model->getTableName()
                )
            );

            $describeRow = $describeInfoList[$describeKey];

            if (array_key_exists(AbstractModel::FIELD_ALLOW_NULL, $modelInfo)) {
                $this->assertEquals(
                    "YES",
                    $describeRow["Null"],
                    sprintf(
                        "The value of column [%s] from table [%s] can be NULL",
                        $modelField,
                        $model->getTableName()
                    )
                );
            } else {
                $this->assertEquals(
                    "NO",
                    $describeRow["Null"],
                    sprintf(
                        "The value of column [%s] from table [%s] can not be NULL",
                        $modelField,
                        $model->getTableName()
                    )
                );
            }

            $this->_checkDbFieldTypes($describeRow, $modelInfo, $model);
            $this->_checkDbForeignKeys($modelField, $modelInfo, $model);
        }
    }

    /**
     * Checks DB foreign keys
     *
     * @param string        $modelField
     * @param array         $modelInfo
     * @param AbstractModel $model
     *
     * @return AbstractModelTest
     */
    private function _checkDbForeignKeys($modelField, $modelInfo, $model)
    {
        /**
         * @var AbstractModel $relationModel
         */
        if (array_key_exists(AbstractModel::FIELD_RELATION, $modelInfo)) {
            $relationModelName = sprintf("\\testS\\models\\%s", $modelInfo[AbstractModel::FIELD_RELATION]);
            $relationModel = new $relationModelName;
        } elseif (array_key_exists(AbstractModel::FIELD_RELATION_TO_PARENT, $modelInfo)) {
            $relationModelName = sprintf("\\testS\\models\\%s", $modelInfo[AbstractModel::FIELD_RELATION_TO_PARENT]);
            $relationModel = new $relationModelName;
        } else {
            return $this;
        }

        $keyColumnUsageInfoList = Db::fetchAll(
            sprintf(
                "SELECT" . " * FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME ='%s'",
                $relationModel->getTableName()
            )
        );

        $hasRelation = false;
        foreach ($keyColumnUsageInfoList as $keyColumnUsageInfo) {
            if ($keyColumnUsageInfo["TABLE_NAME"] === $model->getTableName()
                && $keyColumnUsageInfo["COLUMN_NAME"] === $modelField
            ) {
                $hasRelation = true;
                break;
            }
        }

        $this->assertTrue(
            $hasRelation,
            sprintf(
                "There are no relations between field [%s] from [%s] table and [%s] table",
                $modelField,
                $model->getTableName(),
                $relationModel->getTableName()
            )
        );

        return $this;
    }

    /**
     * Checks DB field types
     *
     * @param array         $describeRow
     * @param array         $modelInfo
     * @param AbstractModel $model
     *
     * @return AbstractModelTest
     */
    private function _checkDbFieldTypes($describeRow, $modelInfo, $model)
    {
        if (!array_key_exists(AbstractModel::FIELD_TYPE, $modelInfo)) {
            return $this;
        }

        $types = [];
        switch ($modelInfo[AbstractModel::FIELD_TYPE]) {
            case AbstractModel::FIELD_TYPE_BOOL:
                $types = ["tinyint(1) unsigned"];
                break;
            case AbstractModel::FIELD_TYPE_INT:
                $types = ["int"];
                if (array_key_exists(AbstractModel::FIELD_VALUE, $modelInfo)) {
                    if (array_key_exists(
                        ValueGenerator::TYPE_ARRAY_KEY,
                        $modelInfo[AbstractModel::FIELD_VALUE]
                    )) {
                        $types = ["tinyint(3) unsigned"];
                    }
                }
                break;
            case AbstractModel::FIELD_TYPE_STRING:
                $types = ["char", "varchar", "text"];
                if (array_key_exists(AbstractModel::FIELD_VALIDATION, $modelInfo)) {
                    if (array_key_exists(
                            Validator::TYPE_MAX_LENGTH,
                            $modelInfo[AbstractModel::FIELD_VALIDATION]
                        )
                        &&
                        array_key_exists(
                            Validator::TYPE_MIN_LENGTH,
                            $modelInfo[AbstractModel::FIELD_VALIDATION]
                        )
                        &&
                        $modelInfo[AbstractModel::FIELD_VALIDATION][Validator::TYPE_MAX_LENGTH] ===
                        $modelInfo[AbstractModel::FIELD_VALIDATION][Validator::TYPE_MIN_LENGTH]
                    ) {
                        $types = [
                            sprintf(
                                "char(%s)",
                                $modelInfo[AbstractModel::FIELD_VALIDATION][Validator::TYPE_MAX_LENGTH]
                            )
                        ];
                    } elseif (array_key_exists(
                        Validator::TYPE_MAX_LENGTH,
                        $modelInfo[AbstractModel::FIELD_VALIDATION]
                    )
                    ) {
                        $types = [
                            sprintf(
                                "varchar(%s)",
                                $modelInfo[AbstractModel::FIELD_VALIDATION][Validator::TYPE_MAX_LENGTH]
                            )
                        ];
                    }
                }
                break;
            default:
                break;
        }

        if (count($types) > 0) {
            $isCorrect = false;
            foreach ($types as $type) {
                if (stripos($describeRow["Type"], $type) !== false) {
                    $isCorrect = true;
                    break;
                }
            }

            $this->assertTrue(
                $isCorrect,
                sprintf(
                    "Incorrect type [%s] for field [%s] from table [%s]. Must be [%s]",
                    $describeRow["Type"],
                    $describeRow["Field"],
                    $model->getTableName(),
                    implode("/", $types)
                )
            );
        }

        return $this;
    }
}