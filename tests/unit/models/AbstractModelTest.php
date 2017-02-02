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
     * @return AbstractModel
     */
    abstract protected function getNewModel();

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    abstract protected function getDataProviderCRUDEmpty();

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    abstract protected function getDataProviderCRUDCorrect();

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    abstract protected function getDataProviderCRUDIncorrect();

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    abstract public function getDataProviderDuplicate();

    /**
     * DB Table structure test
     */
    public function testTableStructure()
    {
        $model = $this->getNewModel();
        $describeInfoList = Db::fetchAll(sprintf("DESCRIBE %s", $model->getTableName()));
        $fields = $model->get();
        foreach ($describeInfoList as $describeInfo) {
            $this->assertTrue(
                array_key_exists($describeInfo["Field"], $fields),
                sprintf(
                    "Unable to find property [%s] for model [%s]",
                    $describeInfo["Field"],
                    get_class($model)
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
                $this->assertSame(
                    "YES",
                    $describeRow["Null"],
                    sprintf(
                        "The value of column [%s] from table [%s] can be NULL",
                        $modelField,
                        $model->getTableName()
                    )
                );
            } else {
                $this->assertSame(
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
                        ValueGenerator::ARRAY_KEY,
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

    /**
     * Test CRUD
     *
     * @param array $createData
     * @param array $createExpected
     * @param array $updateData
     * @param array $updateExpected
     *
     * @dataProvider dataProviderXRUD
     *
     * @return true
     */
    public function testCRUD(
        array $createData = [],
        array $createExpected = [],
        array $updateData = [],
        array $updateExpected = []
    )
    {
        // Create
        $model = $this->getNewModel()->set($createData)->save();
        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $this->_compareExpectedAndActual($createExpected, $errors, true);
            return true;
        }
        $this->_compareExpectedAndActual($createExpected, $model->get());

        // Read created
        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->assertInstanceOf("\\testS\\models\\AbstractModel", $model);
        $this->_compareExpectedAndActual($createExpected, $model->get());

        // Update
        $model->set($updateData)->save();
        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $this->_compareExpectedAndActual($updateExpected, $errors, true);
            return true;
        }
        $this->_compareExpectedAndActual($updateExpected, $model->get());

        // Read updated
        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->assertInstanceOf("\\testS\\models\\AbstractModel", $model);
        $this->_compareExpectedAndActual($updateExpected, $model->get());

        // Delete
        $model->delete();
        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->assertNull($model);

        return true;
    }

    /**
     * Data provider for CRUD
     *
     * @return array
     */
    public function dataProviderXRUD()
    {
        return array_merge(
            $this->getDataProviderCRUDEmpty(),
            $this->getDataProviderCRUDCorrect(),
            $this->getDataProviderCRUDIncorrect()
        );
    }

    /**
     * Test Duplicate
     *
     * @param array $createData
     * @param array $duplicateExpected
     *
     * @dataProvider getDataProviderDuplicate
     *
     * @return true
     */
    public function testDuplicate(
        array $createData = [],
        array $duplicateExpected = []
    )
    {
        // Create and get model
        $model = $this->getNewModel()->set($createData)->save();
        $model = $this->getNewModel()->byId($model->getId())->find();

        // Duplicate
        $duplicatedModel = $model->duplicate();

        // Compare
        $this->_compareExpectedAndActual($duplicateExpected, $duplicatedModel->get());
        $this->assertNotSame($model->getId(), $duplicatedModel->getId());

        // Read duplicated from DB
        $duplicatedModel = $this->getNewModel()->byId($duplicatedModel->getId())->find();
        $this->assertInstanceOf("\\testS\\models\\AbstractModel", $duplicatedModel);
        $this->_compareExpectedAndActual($duplicateExpected, $duplicatedModel->get());

        // Remove
        $model->delete();
        $duplicatedModel->delete();
    }

    /**
     * Compares expected and actual
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $isFullSame
     *
     * @return AbstractModelTest
     */
    private function _compareExpectedAndActual(array $expected, array $actual, $isFullSame = false)
    {
        foreach ($expected as $key => $expectedValue) {
            if (is_string($key)) {
                $this->assertArrayHasKey(
                    $key,
                    $actual,
                    sprintf(
                        "Unable to find key [%s] in actual array with keys [%s]",
                        $key,
                        implode(", ", array_keys($actual))
                    )
                );
            } else {
                $this->assertTrue(
                    in_array($expectedValue, $actual),
                    sprintf(
                        "Unable to find value [%s] in actual array with values [%s]",
                        $expectedValue,
                        implode(", ", $actual)
                    )
                );
            }

            if (is_array($expectedValue)) {
                $this->assertTrue(
                    is_array($actual[$key]),
                    sprintf(
                        "Actual data with key [%s] is not an array. Array expected.",
                        $key
                    )
                );

                $this->_compareExpectedAndActual($expectedValue, $actual[$key], $isFullSame);
                continue;
            }

            $this->assertSame(
                $expectedValue,
                $actual[$key],
                sprintf("Values with key [%s] are not the same", $key)
            );
        }

        if ($isFullSame === false) {
            return $this;
        }

        foreach ($actual as $key => $actualValue) {
            if (is_string($key)) {
                $this->assertArrayHasKey(
                    $key,
                    $expected,
                    sprintf(
                        "Unable to find key [%s] in expected array with keys [%s]",
                        $key,
                        implode(", ", array_keys($expected))
                    )
                );
            } else {
                $this->assertTrue(
                    in_array($actualValue, $expected),
                    sprintf(
                        "Unable to find value [%s] in expected array with values [%s]",
                        $actualValue,
                        implode(", ", $expected)
                    )
                );
            }

            if (is_array($actualValue)) {
                $this->assertTrue(
                    is_array($expected[$key]),
                    sprintf(
                        "Expected data with key [%s] is not an array. Array expected.",
                        $key
                    )
                );

                $this->_compareExpectedAndActual($actualValue, $expected[$key], $isFullSame);
                continue;
            }

            $this->assertSame(
                $actualValue,
                $expected[$key],
                sprintf("Values with key [%s] are not the same", $key)
            );
        }

        return $this;
    }

    /**
     * Gets string with tags
     *
     * @param string $value
     *
     * @return string
     */
    protected function getStringWithTags($value)
    {
        $value =
            "" .
            "<!--...--><!DOCTYPE><a><abbr><address><area><article><aside><audio><b><base><bdi><bdo><blockquote>
            <body><br><button><canvas><caption><cite><code><col><colgroup><datalist><dd><del><details><dfn>
            <dialog><div><dl><dt><em><embed><fieldset><figcaption><figure><footer><form><h1><head><header><hr>
            <html><i><iframe><img><input><ins><kbd><keygen><label><legend><li><link><main><map><mark><menu>
            <menuitem><meta><meter><nav><noscript><object><ol><optgroup><option><output><p><param><picture><pre>
            <progress><q><rp><rt><ruby><s><samp><script><section><select><small><source><span><strong><style>
            <summary><table><tbody><td><textarea><tfoot><th><thead><time><title><tr><track><u><ul><var>
            <video><wbr>" .
            "</a></abbr></address></area></article></aside></audio></b></base></bdi></bdo></blockquote>
            </body></br></button></canvas></caption></cite></code></col></colgroup></datalist></dd></del></details>
            </dialog></div></dl></dt></em></embed></fieldset></figcaption></figure></footer></form></h1></head>
            </hr></html></i></iframe></img></input></ins></kbd></keygen></label></legend></li></link></main></map>
            </mark></menu></menuitem></meta></meter></nav></noscript></object></ol></optgroup></option></output></p>
            </param></picture></pre></progress></q></rp></rt></ruby></s></samp></script></section></select></small>
            </source><span><strong><style></summary></table></tbody></td></textarea></tfoot></th></thead></time>
            </title></tr></track></u></ul></var></video></wbr></dfn></header>" .
            "<script>alert('cracked');</script>" .
            $value .
            "<?php echo '123'; eixt(); ?><% ?> <?= <?php";

        return $value;
    }

    /**
     * Generates random string
     *
     * @param string $length
     *
     * @return string
     */
    protected function generateStringWithLength($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}