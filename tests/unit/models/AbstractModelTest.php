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
            $this->assertEquals("NO", $describeRow["Null"]);

            if (array_key_exists(AbstractModel::FIELD_TYPE, $modelInfo)) {
                $type = null;
                switch ($modelInfo[AbstractModel::FIELD_TYPE]) {
                    case AbstractModel::FIELD_TYPE_BOOL:
                        $type = "tinyint(1) unsigned";
                        break;
                    case AbstractModel::FIELD_TYPE_INT:
                        $type = "int";
                        break;
                    case AbstractModel::FIELD_TYPE_STRING:
                        $type = "varchar";
                        break;
                    default:
                        break;
                }

                if ($type !== null) {
                    $this->assertTrue(
                        stripos($describeRow["Type"], $type) !== false,
                        sprintf(
                            "Incorrect type [%s] for field [%s] from table [%s]. Must be [%s]",
                            $describeRow["Type"],
                            $describeRow["Field"],
                            $model->getTableName(),
                            $type
                        )
                    );
                }
            }
        }
    }
}