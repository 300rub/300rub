<?php

namespace testS\tests\unit\models;

use testS\components\Db;
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

    public function testTableStructure()
    {
        $modelName = sprintf("\\testS\\models\\%s", $this->getModelName());

        /**
         * @var AbstractModel $model
         */
        $model = new $modelName;
        $describeInfoList = Db::fetchAll(sprintf("DESCRIBE %s", $model->getTableName()));
        foreach ($describeInfoList as $describeInfo) {
            $this->assertTrue(
                property_exists($model, $describeInfo["Field"]),
                sprintf(
                    "Unable to find property [%s] for model [%s]",
                    $describeInfo["Field"],
                    $this->getModelName()
                )
            );
        }

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

            if (array_key_exists(AbstractModel::FIELD_TYPE, $modelInfo)) {
                $types = [];
                switch ($modelInfo[AbstractModel::FIELD_TYPE]) {
                    case AbstractModel::FIELD_TYPE_BOOL:
                        $types = ["tinyint(1) unsigned"];
                        break;
                    case AbstractModel::FIELD_TYPE_INT:
                        $types = ["int"];
                        break;
                    case AbstractModel::FIELD_TYPE_STRING:
                        $types = ["char", "varchar", "text"];
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
            }
        }
    }
}