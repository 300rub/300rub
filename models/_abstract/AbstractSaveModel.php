<?php

namespace testS\models\_abstract;

use testS\application\App;
use testS\application\components\Db;
use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractSaveModel extends AbstractFindModel
{

    /**
     * Errors
     *
     * @var array
     */
    private $_errors = [];

    /**
     * Clears errors
     *
     * @return AbstractSaveModel
     */
    private function _clearErrors()
    {
        $this->_errors = [];
        return $this;
    }

    /**
     * Gets errors
     *
     * @return array
     */
    public final function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Adds errors
     *
     * @param string $field  Field
     * @param array  $errors Errors
     *
     * @return AbstractSaveModel
     */
    protected function addErrors($field, array $errors)
    {
        if (count($errors) === 0) {
            return $this;
        }

        if (array_key_exists($field, $this->_errors) === false) {
            $this->_errors[$field] = $errors;
            return $this;
        }

        $this->_errors[$field] = array_merge(
            $this->_errors[$field],
            $errors
        );

        return $this;
    }

    /**
     * Sets field values
     *
     * @param array $fields Fields
     *
     * @return AbstractModel
     */
    public final function set(array $fields)
    {
        return $this
            ->_setRelations($fields)
            ->_setRelationsToParent($fields)
            ->_setTypes($fields)
            ->_setValues()
            ->_setNulls($fields)
            ->_setId($fields);
    }

    /**
     * Sets relations
     *
     * @param array $fields Fields
     *
     * @return AbstractSaveModel
     */
    private function _setRelations(array $fields)
    {
        $info = $this->getFieldsInfo();

        // Sets from model arrays
        foreach ($fields as $field => $value) {
            $relationIdField = $this->getRelationIdFields($field);
            if (array_key_exists($field, $this->getFields()) === false) {
                continue;
            }

            if ($value instanceof self === false
                && is_array($value) === false
            ) {
                continue;
            }

            if (array_key_exists($relationIdField, $info) === false) {
                continue;
            }

            if ($this->isNew() === false) {
                continue;
            }

            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$relationIdField]
            );
            if ($hasRelation === false) {
                continue;
            }

            $hasNotChange = array_key_exists(
                self::FIELD_NOT_CHANGE_ON_UPDATE,
                $info[$relationIdField]
            );
            if ($hasNotChange === true) {
                continue;
            }

            $relationModel = $value;
            if ($value instanceof self === false) {
                $isFind = true;
                if ($this->isNew() === true) {
                    $isFind = false;
                }

                $relationModel = $this->getRelationModelByFieldName(
                    $relationIdField,
                    $isFind
                );
                $relationModel->set($value);
            }

            $this->setField($field, $relationModel);

            if ($relationModel->getId() > 0) {
                $this->setField($relationIdField, $relationModel->getId());
            }
        }

        // Sets relation IDs
        foreach ($fields as $field => $value) {
            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $info[$field]
            );
            if (array_key_exists($field, $info) === false
                || $hasRelation === false
                || (int)$value === 0
            ) {
                continue;
            }

            $this->setField($field, (int)$value);
        }

        return $this;
    }

    /**
     * Sets relations to parent
     *
     * @param array $fields Fields
     *
     * @return AbstractSaveModel
     */
    private function _setRelationsToParent(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            $hasRelation = array_key_exists(
                self::FIELD_RELATION_TO_PARENT,
                $info[$field]
            );

            if (array_key_exists($field, $this->getFields()) === false
                || array_key_exists($field, $info) === false
                || $hasRelation === false
            ) {
                continue;
            }

            $hasNotChange = array_key_exists(
                self::FIELD_NOT_CHANGE_ON_UPDATE,
                $info[$field]
            );
            if ($this->isNew() === false
                && $hasNotChange === true
            ) {
                continue;
            }

            $this->setField(
                $field,
                ValueGenerator::factory(ValueGenerator::INT, $value)->generate()
            );
        }

        return $this;
    }

    /**
     * Sets types
     *
     * @param array $fields Fields
     *
     * @return AbstractSaveModel
     */
    private function _setTypes(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (array_key_exists($field, $this->getFields()) === false
                || array_key_exists($field, $info) === false
                || array_key_exists(self::FIELD_TYPE, $info[$field]) === false
            ) {
                continue;
            }

            $hasNotChange = array_key_exists(
                self::FIELD_NOT_CHANGE_ON_UPDATE,
                $info[$field]
            );
            if ($this->isNew() === false
                && $hasNotChange === true
            ) {
                continue;
            }

            if (is_array($value) === true
                || is_object($value) === true
            ) {
                $value = null;
            }

            $this->_setFieldByType($field, $value, $info);
        }

        return $this;
    }

    /**
     * Sets field value by type
     *
     * @param string $field Field
     * @param mixed  $value Value
     * @param array  $info  Fields info
     *
     * @return void
     */
    private function _setFieldByType($field, $value, $info)
    {
        switch ($info[$field][self::FIELD_TYPE]) {
            case self::FIELD_TYPE_STRING:
                $this->setField(
                    $field,
                    ValueGenerator::factory(
                        ValueGenerator::STRING,
                        $value
                    )->generate()
                );
                break;
            case self::FIELD_TYPE_INT:
                $this->setField(
                    $field,
                    ValueGenerator::factory(
                        ValueGenerator::INT,
                        $value
                    )->generate()
                );
                break;
            case self::FIELD_TYPE_FLOAT:
                $this->setField(
                    $field,
                    ValueGenerator::factory(
                        ValueGenerator::FLOAT,
                        $value
                    )->generate()
                );
                break;
            case self::FIELD_TYPE_BOOL:
                $this->setField(
                    $field,
                    ValueGenerator::factory(
                        ValueGenerator::BOOL,
                        $value
                    )->generate()
                );
                break;
            case self::FIELD_TYPE_DATETIME:
                $hasCurrentDateTime = array_key_exists(
                    self::FIELD_CURRENT_DATE_TIME,
                    $info[$field]
                );
                if ($hasCurrentDateTime === true) {
                    $value = 'now';
                }

                $this->setField(
                    $field,
                    ValueGenerator::factory(
                        ValueGenerator::DATETIME,
                        $value
                    )->generate()
                );
                break;
            default:
                break;
        }
    }

    /**
     * Sets values
     *
     * @return AbstractSaveModel
     */
    private function _setValues()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $fieldInfo) {
            if (array_key_exists(self::FIELD_VALUE, $fieldInfo) === false) {
                continue;
            }

            $hasNotChange = array_key_exists(
                self::FIELD_NOT_CHANGE_ON_UPDATE,
                $info[$field]
            );
            if ($this->isNew() === false
                && $hasNotChange === true
            ) {
                continue;
            }

            foreach ($fieldInfo[self::FIELD_VALUE] as $key => $value) {
                $this->_setFieldValue($field, $key, $value);
            }
        }

        return $this;
    }

    /**
     * Sets field value
     *
     * @param string         $field Field
     * @param string|integer $key   FIELD_VALUE key
     * @param string|array   $value FIELD_VALUE value
     *
     * @return AbstractSaveModel
     */
    private function _setFieldValue($field, $key, $value)
    {
        if (is_string($key) === false) {
            $this->setField(
                $field,
                ValueGenerator::factory(
                    $value,
                    $this->get($field)
                )->generate()
            );

            return $this;
        }

        if (is_string($value) === true
            && stripos($value, '{') === 0
        ) {
            $value = $this->get(
                str_replace(['{', '}'], '', $value)
            );
        } elseif (is_array($value) === true) {
            foreach ($value as &$valueGeneratorVal) {
                if (is_string($valueGeneratorVal) === true
                    && stripos($valueGeneratorVal, '{') === 0
                ) {
                    $valueGeneratorVal = $this->get(
                        str_replace(['{', '}'], '', $valueGeneratorVal)
                    );
                }
            }
        }

        $this->setField(
            $field,
            ValueGenerator::factory(
                $key,
                $this->get($field),
                $value
            )->generate()
        );

        return $this;
    }

    /**
     * Sets null values
     *
     * @param array $fields Fields
     *
     * @return AbstractSaveModel
     */
    private function _setNulls(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach (array_keys($fields) as $field) {
            $isAllowNull = array_key_exists(
                self::FIELD_ALLOW_NULL,
                $info[$field]
            );

            if (array_key_exists($field, $this->getFields()) === false
                || array_key_exists($field, $info) === false
                || $isAllowNull === false
                || $info[$field][self::FIELD_ALLOW_NULL] !== true
                || empty($this->get($field)) === false
            ) {
                continue;
            }

            $this->setField($field, null);
        }

        return $this;
    }

    /**
     * Sets ID
     *
     * @param array $fields Fields
     *
     * @return AbstractSaveModel
     */
    private function _setId(array $fields)
    {
        if (array_key_exists(self::PK_FIELD, $fields) === true) {
            $this->setField(self::PK_FIELD, (int)$fields[self::PK_FIELD]);
        }

        return $this;
    }

    /**
     * Saves model in DB
     *
     * @throws ModelException
     *
     * @return AbstractModel
     */
    public final function save()
    {
        $this->_clearErrors();
        if (count($this->validate()->getErrors()) > 0) {
            return $this;
        }

        try {
            $this->beforeSave();
            if (count($this->getErrors()) > 0) {
                return $this;
            }

            $this
                ->_setFieldsForDbBeforeSave()
                ->_save();

            $this->getDb()->reset();

            $this->afterSave();
        } catch (\Exception $e) {
            $this->_onSaveFailure($e);
        }

        return $this;
    }

    /**
     * Saves model
     *
     * @return AbstractSaveModel
     */
    private function _save()
    {
        if ($this->getId() > 0) {
            $this->_update();
            return $this;
        }

        $this->_create();
        return $this;
    }

    /**
     * Creates a new record in DB
     *
     * @return void
     */
    private function _create()
    {
        $this->set([self::PK_FIELD => (int)$this->getDb()->insert()]);
    }

    /**
     * Updates the record in DB
     *
     * @return void
     */
    private function _update()
    {
        $this->getDb()
            ->setWhere('id = :id')
            ->addParameter('id', $this->getId())
            ->update();
    }

    /**
     * Updates many fields in DB
     *
     * @param array  $data       Data
     * @param string $where      Where condition
     * @param array  $parameters Parameters
     *
     * @return AbstractModel
     */
    protected function updateMany(array $data, $where, $parameters = [])
    {
        $dbObject = $this->getDb();

        $dbObject->setWhere($where);
        if (count($parameters) > 0) {
            foreach ($parameters as $parameterKey => $parameterValue) {
                $dbObject->addParameter($parameterKey, $parameterValue);
            }
        }

        foreach ($data as $field => $parameter) {
            $dbObject->addField($field);
            $dbObject->addParameter($field, $parameter);
        }

        $dbObject->update();

        return $this;
    }

    /**
     * Sets fields for DB
     *
     * @return AbstractSaveModel
     */
    private function _setFieldsForDbBeforeSave()
    {
        $info = $this->getFieldsInfo();
        $dbObject = $this->getDb();

        foreach ($info as $field => $fieldInfo) {
            $dbObject->addField($field);

            if (array_key_exists(self::FIELD_TYPE, $fieldInfo) === false) {
                $dbObject->addParameter($field, $this->get($field));
                continue;
            }

            switch ($fieldInfo[self::FIELD_TYPE]) {
                case self::FIELD_TYPE_BOOL:
                    $dbObject->addParameter(
                        $field,
                        ValueGenerator::factory(
                            ValueGenerator::BOOL_INT,
                            $this->get($field)
                        )->generate()
                    );
                    break;
                case self::FIELD_TYPE_STRING:
                    $dbObject->addParameter(
                        $field,
                        ValueGenerator::factory(
                            ValueGenerator::STRING,
                            $this->get($field)
                        )->generate()
                    );
                    break;
                case self::FIELD_TYPE_DATETIME:
                    $dbObject->addParameter(
                        $field,
                        ValueGenerator::factory(
                            ValueGenerator::DATETIME_AS_STRING,
                            $this->get($field)
                        )->generate()
                    );
                    break;
                default:
                    $dbObject->addParameter($field, $this->get($field));
                    break;
            }
        }

        return $this;
    }

    /**
     * Runs after saving
     *
     * @return void
     */
    protected function afterSave()
    {
    }

    /**
     * On save failure
     *
     * @param \Exception $exception Exception
     *
     * @throws ModelException
     *
     * @return void
     */
    private function _onSaveFailure(\Exception $exception)
    {
        $info = $this->getFieldsInfo();
        $fields = [];

        foreach (array_keys($info) as $field) {
            $value = $this->get($field);

            if (is_object($value) === true) {
                continue;
            }

            if (is_bool($value) === true) {
                $value = (int)$value;
            }

            $fields[] = sprintf('%s: %s', $field, $value);
        }

        throw new ModelException(
            '{e}. Unable to save the model {class} with the fields: {fields}',
            [
                'e'      => $exception->getMessage(),
                'class'  => get_class($this),
                'fields' => implode(', ', $fields)
            ]
        );
    }

    /**
     * Validates model's fields
     *
     * @return AbstractModel
     */
    public final function validate()
    {
        $info = $this->getFieldsInfo();

        foreach (array_keys($info) as $field) {
            $rules = $this->getValidationRulesForField($field);
            if (count($rules) === 0) {
                continue;
            }

            $this->addErrors(
                $field,
                App::getInstance()
                    ->getValidator()
                    ->validate($this->get($field), $rules)
                    ->getErrors()
            );
        }

        return $this;
    }

    /**
     * Gets parsed errors
     *
     * @return array
     */
    public function getParsedErrors()
    {
        $parsedErrors = [];
        $errors = $this->getErrors();

        foreach ($errors as $key => $values) {
            if (count($values) === 0) {
                continue;
            }

            if ($this->get($key) instanceof self) {
                $parsedErrors[$key] = $this->get($key)->getParsedErrors();
                continue;
            }

            $parsedErrors[$key] = App::getInstance()
                ->getLanguage()
                ->getMessage('validation', $values[0]);
        }

        return $parsedErrors;
    }

    /**
     * Gets validation rules for field
     *
     * @param string $field Field
     *
     * @return array
     *
     * @throws ModelException
     */
    public final function getValidationRulesForField($field)
    {
        $info = $this->getFieldsInfo();
        if (array_key_exists($field, $info) === false) {
            throw new ModelException(
                'Unable to find field: {field} for model: {model}',
                [
                    'field' => $field,
                    'model' => get_class($this)
                ]
            );
        }

        if (array_key_exists(self::FIELD_VALIDATION, $info[$field]) === false) {
            return [];
        }

        $rules = [];
        foreach ($info[$field][self::FIELD_VALIDATION] as $key => $value) {
            if (is_string($key) === false) {
                $key = $value;
            }

            $rules[$key] = $value;
        }

        return $rules;
    }

    /**
     * Runs before saving
     *
     * @return void
     */
    protected function beforeSave()
    {
        $this
            ->_setFieldsBeforeSave()
            ->_setRelationsBeforeSave()
            ->_checkParentsBeforeSave();
    }

    /**
     * Sets fields before save
     *
     * @return AbstractModel
     */
    private function _setFieldsBeforeSave()
    {
        foreach ($this->getFieldsInfo() as $field => $parameters) {
            $hasBeforeSave = array_key_exists(
                self::FIELD_BEFORE_SAVE,
                $parameters
            );
            if ($hasBeforeSave === true) {
                $beforeSave = $parameters[self::FIELD_BEFORE_SAVE];
                foreach ($beforeSave as $key => $value) {
                    if (is_string($key) === true) {
                        $method = $key;
                        if (method_exists($this, $method) === true) {
                            $this->setField(
                                $field,
                                $this->$method($this->get($field), $value)
                            );
                        }

                        continue;
                    }

                    $method = $value;
                    if (method_exists($this, $method) === true) {
                        $this->setField(
                            $field,
                            $this->$method($this->get($field))
                        );
                    }
                }
            }

            if (array_key_exists(self::FIELD_UNIQUE, $parameters) === true) {
                $model = $this
                    ->exceptId($this->getId())
                    ->checkUnique($field)->find();
                if ($model !== null) {
                    $this->addErrors($field, [Validator::TYPE_UNIQUE]);
                }
            }
        }

        return $this;
    }

    /**
     * Adds condition to check unique value
     *
     * @param string $field Field
     *
     * @return AbstractModel
     */
    protected function checkUnique($field)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.%s = :field',
                Db::DEFAULT_ALIAS,
                $field
            )
        );
        $this->getDb()->addParameter('field', $this->get($field));

        return $this;
    }

    /**
     * Sets relation fields before save
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    private function _setRelationsBeforeSave()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $relationInfo) {
            $hasRelation = array_key_exists(
                self::FIELD_RELATION,
                $relationInfo
            );
            if ($hasRelation === false) {
                continue;
            }

            $relationName = $this->getRelationName($field);
            $modelName = $relationInfo[self::FIELD_RELATION];

            $relationModel = $this->get($relationName);
            if ($relationModel instanceof $modelName === false) {
                $relationModel = $this->getModelByName($modelName);

                if ($this->get($field) !== 0) {
                    $relationModel = $relationModel
                        ->byId($this->get($field))
                        ->find();

                    if ($relationModel instanceof $modelName === false) {
                        throw new ModelException(
                            'Unable to find relation with name: ' .
                            '{name} by id: {id}',
                            [
                                'name' => $relationName,
                                'id'   => $this->get($field)
                            ]
                        );
                    }
                }
            }

            $relationModel->save();
            if (count($relationModel->getErrors()) > 0) {
                $this->addErrors($relationName, $relationModel->getErrors());
            }

            $this->setField($field, $relationModel->getId());
            $this->setField($relationName, $relationModel);
        }

        return $this;
    }

    /**
     * Checks parents before save
     *
     * @throws ModelException
     *
     * @return AbstractModel
     */
    private function _checkParentsBeforeSave()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $fieldInfo) {
            $hasRelation = array_key_exists(
                self::FIELD_RELATION_TO_PARENT,
                $fieldInfo
            );
            if ($hasRelation === false) {
                continue;
            }

            $value = $this->get($field);

            $isAllowNull = array_key_exists(
                self::FIELD_ALLOW_NULL,
                $fieldInfo
            );
            if ($isAllowNull === true
                && $value === null
            ) {
                continue;
            }

            if ($value === 0) {
                throw new ModelException(
                    'Unable to save {className} because {field} is 0',
                    [
                        'className' => get_class($this),
                        'field'     => $field
                    ]
                );
            }

            $modelName = $fieldInfo[self::FIELD_RELATION_TO_PARENT];
            $model = $this->getModelByName($modelName);
            if ($model instanceof AbstractModel === false) {
                $model = $model->byId($value)->find();
                if ($model instanceof AbstractModel === false) {
                    throw new ModelException(
                        'Unable to find model: {model} with ID = {id}',
                        [
                            'model' => $modelName,
                            'id'    => $value
                        ]
                    );
                }
            }
        }

        return $this;
    }
}
