<?php

namespace ss\tests\phpunit\models\_abstract\_base;

use ss\application\App;
use ss\application\components\common\Validator;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;
use ss\tests\phpunit\models\_abstract\AbstractModelTest;

/**
 * Abstract class to test DB structure
 */
abstract class AbstractDbModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return AbstractModel
     */
    abstract protected function getNewModel();

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
            ->execute(
                sprintf(
                    'DESCRIBE %s',
                    $model->getTableName()
                )
            )
            ->fetchAll();
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
            }

            if ($hasKey === false) {
                $this->assertSame(
                    'NO',
                    $describeRow['Null'],
                    sprintf(
                        'The value of column [%s] from ' .
                        'table [%s] can not be NULL',
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
     * @param string        $modelField Field
     * @param array         $modelInfo  Info
     * @param AbstractModel $model      Model
     *
     * @return AbstractModelTest
     */
    private function _checkDbForeignKeys($modelField, $modelInfo, $model)
    {
        $hasRelation = array_key_exists(
            AbstractModel::FIELD_RELATION,
            $modelInfo
        );
        $hasRelationParent = array_key_exists(
            AbstractModel::FIELD_RELATION_TO_PARENT,
            $modelInfo
        );

        $relationModel = null;
        if ($hasRelation === true) {
            $relationModel = $this->getModelByName(
                $modelInfo[AbstractModel::FIELD_RELATION]
            );
        }

        if ($hasRelationParent === true) {
            $relationModel = $this->getModelByName(
                $modelInfo[AbstractModel::FIELD_RELATION_TO_PARENT]
            );
        }

        if ($relationModel === null) {
            return $this;
        }

        $keyColumnUsages = App::getInstance()
            ->getDb()
            ->execute(
                sprintf(
                    'SELECT' .
                    ' * FROM information_schema.KEY_COLUMN_USAGE' .
                    ' WHERE REFERENCED_TABLE_NAME =\'%s\'',
                    $relationModel->getTableName()
                )
            )
            ->fetchAll();

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
                'There are no relations between field ' .
                '[%s] from [%s] table and [%s] table',
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
     * @param array         $describeRow Describe row
     * @param array         $modelInfo   Model info
     * @param AbstractModel $model       Model
     *
     * @return AbstractModelTest
     */
    private function _checkDbFieldTypes($describeRow, $modelInfo, $model)
    {
        if (array_key_exists(AbstractModel::FIELD_TYPE, $modelInfo) === false) {
            return $this;
        }

        $types = $this->_getFieldTypes($modelInfo);

        if (count($types) === 0) {
            return $this;
        }

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

        return $this;
    }

    /**
     * Gets field types
     *
     * @param array $modelInfo Field info
     *
     * @return array
     */
    private function _getFieldTypes($modelInfo)
    {
        $type = $modelInfo[AbstractModel::FIELD_TYPE];

        if ($type === AbstractModel::FIELD_TYPE_BOOL) {
            return $this->_getBoolFieldType();
        }

        if ($type === AbstractModel::FIELD_TYPE_INT) {
            return $this->_getIntFieldType($modelInfo);
        }

        if ($type === AbstractModel::FIELD_TYPE_STRING) {
            return $this->_getStringFieldType($modelInfo);
        }

        return [];
    }

    /**
     * Gets bool field type
     *
     * @return array
     */
    private function _getBoolFieldType()
    {
        return ['tinyint(1) unsigned'];
    }

    /**
     * Gets integer field type
     *
     * @param array $modelInfo Model info
     *
     * @return array
     */
    private function _getIntFieldType($modelInfo)
    {
        $hasFieldValue = array_key_exists(
            AbstractModel::FIELD_VALUE,
            $modelInfo
        );
        if ($hasFieldValue === true) {
            $hasArrayKey = array_key_exists(
                ValueGenerator::ARRAY_KEY,
                $modelInfo[AbstractModel::FIELD_VALUE]
            );
            if ($hasArrayKey === true) {
                return ['tinyint(3) unsigned'];
            }
        }

        return ['int'];
    }

    /**
     * Gets string field type
     *
     * @param array $modelInfo Model info
     *
     * @return array
     */
    private function _getStringFieldType($modelInfo)
    {
        $hasValidation = array_key_exists(
            AbstractModel::FIELD_VALIDATION,
            $modelInfo
        );
        if ($hasValidation === false) {
            return ['char', 'varchar', 'text'];
        }

        $validation = $modelInfo[AbstractModel::FIELD_VALIDATION];

        $hasMaxLength = array_key_exists(
            Validator::TYPE_MAX_LENGTH,
            $validation
        );
        $hasMinLength = array_key_exists(
            Validator::TYPE_MIN_LENGTH,
            $validation
        );

        if ($hasMaxLength === true
            && $hasMinLength === true
        ) {
            $maxLength = $validation[Validator::TYPE_MAX_LENGTH];
            $minLength = $validation[Validator::TYPE_MIN_LENGTH];
            if ($maxLength === $minLength) {
                return [sprintf('char(%s)', $maxLength)];
            }
        }

        if ($hasMaxLength === true) {
            return [
                sprintf(
                    'varchar(%s)',
                    $validation[Validator::TYPE_MAX_LENGTH]
                )
            ];
        }

        return ['char', 'varchar', 'text'];
    }
}
