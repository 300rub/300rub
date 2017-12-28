<?php

namespace testS\tests\unit\models\_abstract;

use testS\application\App;
use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\_abstract\AbstractModel;

/**
 * Class AbstractModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    abstract protected function getDataProviderEmpty();

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    abstract protected function getDataProviderCorrect();

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    abstract protected function getDataProviderIncorrect();

    /**
     * Test duplicate
     *
     * @return void
     */
    abstract public function testDuplicate();

    /**
     * DB Table structure test
     *
     * @return void
     */
    public function testTableStructure()
    {
        $model = $this->getNewModel();
        $describeInfoList = App::getInstance()
            ->getDb()
            ->fetchAll(
                sprintf(
                    'DESCRIBE %s',
                    $model->getTableName()
                )
            );
        $fields = $model->get();
        foreach ($describeInfoList as $describeInfo) {
            $this->assertTrue(
                array_key_exists($describeInfo['Field'], $fields),
                sprintf(
                    'Unable to find property [%s] for model [%s]',
                    $describeInfo['Field'],
                    get_class($model)
                )
            );
        }

        $modelInfoList = $model->getFieldsInfo();
        foreach ($modelInfoList as $modelField => $modelInfo) {
            $describeKey = null;
            foreach ($describeInfoList as $key => $describeInfo) {
                if ($modelField === $describeInfo['Field']) {
                    $describeKey = $key;
                    break;
                }
            }

            $this->assertNotNull(
                $describeKey,
                sprintf(
                    'Unable to find field [%s] from table [%s]',
                    $modelField,
                    $model->getTableName()
                )
            );

            $describeRow = $describeInfoList[$describeKey];

            $hasKey = array_key_exists(
                AbstractModel::FIELD_ALLOW_NULL,
                $modelInfo
            );
            if ($hasKey === true) {
                $this->assertSame(
                    'YES',
                    $describeRow['Null'],
                    sprintf(
                        'The value of column [%s] from table [%s] can be NULL',
                        $modelField,
                        $model->getTableName()
                    )
                );
            } else {
                $this->assertSame(
                    'NO',
                    $describeRow['Null'],
                    sprintf(
                        'The value of column [%s] from table [%s] can not be NULL',
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
        if (array_key_exists(AbstractModel::FIELD_RELATION, $modelInfo)) {
            $relationModelName = sprintf("\\testS\\models\\%s", $modelInfo[AbstractModel::FIELD_RELATION]);
            $relationModel = new $relationModelName;
        } elseif (array_key_exists(AbstractModel::FIELD_RELATION_TO_PARENT, $modelInfo)) {
            $relationModelName = sprintf("\\testS\\models\\%s", $modelInfo[AbstractModel::FIELD_RELATION_TO_PARENT]);
            $relationModel = new $relationModelName;
        } else {
            return $this;
        }

        $keyColumnUsages = App::getInstance()
            ->getDb()
            ->fetchAll(
                sprintf(
                    'SELECT' . " * FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME ='%s'",
                    $relationModel->getTableName()
                )
            );

        $hasRelation = false;
        foreach ($keyColumnUsages as $keyColumnUsage) {
            if ($keyColumnUsage['TABLE_NAME'] === $model->getTableName()
                && $keyColumnUsage['COLUMN_NAME'] === $modelField
            ) {
                $hasRelation = true;
                break;
            }
        }

        $this->assertTrue(
            $hasRelation,
            sprintf(
                'There are no relations between field [%s] from [%s] table and [%s] table',
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
                $types = ['tinyint(1) unsigned'];
                break;
            case AbstractModel::FIELD_TYPE_INT:
                $types = ['int'];
                if (array_key_exists(AbstractModel::FIELD_VALUE, $modelInfo)) {
                    if (array_key_exists(
                        ValueGenerator::ARRAY_KEY,
                        $modelInfo[AbstractModel::FIELD_VALUE]
                    )
                    ) {
                        $types = ['tinyint(3) unsigned'];
                    }
                }
                break;
            case AbstractModel::FIELD_TYPE_STRING:
                $types = ['char', 'varchar', 'text'];
                if (array_key_exists(AbstractModel::FIELD_VALIDATION, $modelInfo)) {
                    if (array_key_exists(
                        Validator::TYPE_MAX_LENGTH,
                        $modelInfo[AbstractModel::FIELD_VALIDATION]
                    )
                        && array_key_exists(
                            Validator::TYPE_MIN_LENGTH,
                            $modelInfo[AbstractModel::FIELD_VALIDATION]
                        )
                        && $modelInfo[AbstractModel::FIELD_VALIDATION][Validator::TYPE_MAX_LENGTH] === $modelInfo[AbstractModel::FIELD_VALIDATION][Validator::TYPE_MIN_LENGTH]
                    ) {
                        $types = [
                            sprintf(
                                'char(%s)',
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
                                'varchar(%s)',
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
                if (stripos($describeRow['Type'], $type) !== false) {
                    $isCorrect = true;
                    break;
                }
            }

            $this->assertTrue(
                $isCorrect,
                sprintf(
                    'Incorrect type [%s] for field [%s] ' .
                    'from table [%s]. Must be [%s]',
                    $describeRow['Type'],
                    $describeRow['Field'],
                    $model->getTableName(),
                    implode('/', $types)
                )
            );
        }

        return $this;
    }

    /**
     * Test CRUD
     *
     * @param array  $createData      Data to create
     * @param array  $createExpected  Create expected
     * @param array  $updateData      Data to update
     * @param array  $updateExpected  Update expected
     * @param string $createException Expected created exception
     * @param string $updateException Expected update exception
     * @param array  $exceptRelations Except relations
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
        $exceptRelations = []
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

        $this->compareExpectedAndActual($createExpected, $model->get());

        // Read created.
        $model = $this->getNewModel()
            ->byId($model->getId())
            ->withRelations()
            ->exceptRelations($exceptRelations)
            ->find();
        $this->assertInstanceOf(
            "\\testS\\models\\_abstract\\AbstractModel",
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
                ->withRelations()
                ->exceptRelations($exceptRelations)
                ->find();
            $this->assertInstanceOf(
                "\\testS\\models\\_abstract\\AbstractModel",
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

    /**
     * Data provider for CRUD
     *
     * @return array
     */
    public function dataProvider()
    {
        return array_merge(
            $this->getDataProviderEmpty(),
            $this->getDataProviderCorrect(),
            $this->getDataProviderIncorrect()
        );
    }

    /**
     * Test Duplicate
     *
     * @param array  $createData        Data to create
     * @param array  $duplicateExpected Expected data after duplication
     * @param string $expectedException Expected exception
     * @param array  $exceptRelations   Except relations
     *
     * @return AbstractBaseModelTest
     *
     * @throws \Exception
     */
    protected function duplicate(
        array $createData = [],
        array $duplicateExpected = [],
        $expectedException = null,
        $exceptRelations = []
    ) {
        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        // Create and get model.
        $model = $this->getNewModel()
            ->set($createData)
            ->save();
        $model = $this->getNewModel()
            ->byId($model->getId())
            ->withRelations()
            ->exceptRelations($exceptRelations)
            ->find();

        // Duplicate.
        try {
            $duplicatedModel = $model->duplicate();
        } catch (\Exception $e) {
            $model->delete();
            throw $e;
        }

        $errors = $duplicatedModel->getErrors();
        if (count($errors) > 0) {
            $this->compareExpectedAndActual(
                $duplicateExpected,
                $errors,
                true
            );
            $model->delete();
            return $this;
        }

        // Compare.
        $this->compareExpectedAndActual(
            $duplicateExpected,
            $duplicatedModel->get()
        );
        $this->assertNotSame(
            $model->getId(),
            $duplicatedModel->getId()
        );

        // Read duplicated from DB.
        $duplicatedModel = $this->getNewModel()
            ->byId($duplicatedModel->getId())
            ->withRelations()
            ->exceptRelations($exceptRelations)
            ->find();
        $this->assertInstanceOf(
            "\\testS\\models\\_abstract\\AbstractModel",
            $duplicatedModel
        );
        $this->compareExpectedAndActual(
            $duplicateExpected,
            $duplicatedModel->get()
        );

        // Compare relation IDs.
        $info = $model->getFieldsInfo();
        foreach (array_keys($info) as $field) {
            $hasKey = array_key_exists(
                AbstractModel::FIELD_RELATION,
                $info[$field]
            );
            if ($hasKey === true) {
                $this->assertNotSame(
                    $model->get($field),
                    $duplicatedModel->get($field)
                );
            }

            $hasKey = array_key_exists(
                AbstractModel::FIELD_RELATION_TO_PARENT,
                $info[$field]
            );
            if ($hasKey === true) {
                $this->assertSame(
                    $model->get($field),
                    $duplicatedModel->get($field)
                );
            }
        }

        // Remove.
        $model->delete();
        $duplicatedModel->delete();

        return $this;
    }

    /**
     * Gets string with tags
     *
     * @param string $value Value
     *
     * @return string
     */
    protected function getStringWithTags($value)
    {
        $value = '' .
            '<!--...--><!DOCTYPE><a><abbr><address><area><article>
            <aside><audio><b><base><bdi><bdo><blockquote>
            <body><br><button><canvas><caption><cite><code><col>
            <colgroup><datalist><dd><del><details><dfn>
            <dialog><div><dl><dt><em><embed><fieldset><figcaption>
            <figure><footer><form><h1><head><header><hr>
            <html><i><iframe><img><input><ins><kbd><keygen><label>
            <legend><li><link><main><map><mark><menu>
            <menuitem><meta><meter><nav><noscript><object><ol>
            <optgroup><option><output><p><param><picture><pre>
            <progress><q><rp><rt><ruby><s><samp><script><section>
            <select><small><source><span><strong><style>
            <summary><table><tbody><td><textarea><tfoot><th>
            <thead><time><title><tr><track><u><ul><var>
            <video><wbr></a></abbr></address></area></article>
            </aside></audio></b></base></bdi></bdo></blockquote>
            </body></br></button></canvas></caption></cite></code>
            </col></colgroup></datalist></dd></del></details>
            </dialog></div></dl></dt></em></embed></fieldset>
            </figcaption></figure></footer></form></h1></head>
            </hr></html></i></iframe></img></input></ins></kbd>
            </keygen></label></legend></li></link></main></map>
            </mark></menu></menuitem></meta></meter></nav></noscript>
            </object></ol></optgroup></option></output></p>
            </param></picture></pre></progress></q></rp></rt>
            </ruby></s></samp></script></section></select></small>
            </source><span><strong><style></summary></table></tbody>
            </td></textarea></tfoot></th></thead></time>
            </title></tr></track></u></ul></var></video></wbr></dfn>
            </header><script>alert("cracked");</script>' .
            $value .
            '<?php echo "123"; eixt(); ?><% ?> <?= <?php';

        return $value;
    }
}
