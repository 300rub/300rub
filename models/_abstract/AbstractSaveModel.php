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
     * @param string $field
     * @param array  $errors
     *
     * @return AbstractSaveModel
     */
    protected function addErrors($field, array $errors)
    {
        if (count($errors) === 0) {
            return $this;
        }

        if (array_key_exists($field, $this->_errors)) {
            $this->_errors[$field] = array_merge($this->_errors[$field], $errors);
        } else {
            $this->_errors[$field] = $errors;
        }

        return $this;
    }

    /**
     * Sets field values
     *
     * @param array $fields
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
     * @param array $fields
     *
     * @return AbstractSaveModel
     */
    private function _setRelations(array $fields)
    {
        $info = $this->getFieldsInfo();

        // Sets from model arrays
        foreach ($fields as $field => $value) {
            $relationIdField = $this->getRelationIdFields($field);
            if (!array_key_exists($field, $this->getFields())
                || (!$value instanceof self && !is_array($value))
                || !array_key_exists($relationIdField, $info)
                || !array_key_exists(self::FIELD_RELATION, $info[$relationIdField])
            ) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$relationIdField])
            ) {
                continue;
            }

            if ($value instanceof self) {
                $relationModel = $value;
            } else {
                $relationModel = $this->getRelationModelByFieldName($relationIdField, !$this->isNew());
                $relationModel->set($value);
            }

            $this->setField($field, $relationModel);

            if ($relationModel->getId()) {
                $this->setField($relationIdField, $relationModel->getId());
            }
        }

        // Sets relation IDs
        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_RELATION, $info[$field])
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
     * @param array $fields
     *
     * @return AbstractSaveModel
     */
    private function _setRelationsToParent(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $this->getFields())
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_RELATION_TO_PARENT, $info[$field])
            ) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$field])
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
     * @param array $fields
     *
     * @return AbstractSaveModel
     */
    private function _setTypes(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $this->getFields())
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_TYPE, $info[$field])
            ) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$field])
            ) {
                continue;
            }

            if (is_array($value) || is_object($value)) {
                $value = null;
            }

            switch ($info[$field][self::FIELD_TYPE]) {
                case self::FIELD_TYPE_STRING:
                    $this->setField($field, ValueGenerator::factory(ValueGenerator::STRING, $value)->generate());
                    break;
                case self::FIELD_TYPE_INT:
                    $this->setField($field, ValueGenerator::factory(ValueGenerator::INT, $value)->generate());
                    break;
                case self::FIELD_TYPE_FLOAT:
                    $this->setField($field, ValueGenerator::factory(ValueGenerator::FLOAT, $value)->generate());
                    break;
                case self::FIELD_TYPE_BOOL:
                    $this->setField($field, ValueGenerator::factory(ValueGenerator::BOOL, $value)->generate());
                    break;
                case self::FIELD_TYPE_DATETIME:
                    if (array_key_exists(self::FIELD_CURRENT_DATE_TIME, $info[$field])) {
                        $value = 'now';
                    }

                    $this->setField($field, ValueGenerator::factory(ValueGenerator::DATETIME, $value)->generate());
                    break;
                default:
                    break;
            }
        }

        return $this;
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
            if (!array_key_exists(self::FIELD_VALUE, $fieldInfo)) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$field])
            ) {
                continue;
            }

            foreach ($fieldInfo[self::FIELD_VALUE] as $valueGeneratorKey => $valueGeneratorValue) {
                if (!is_string($valueGeneratorKey)) {
                    $this->setField($field, ValueGenerator::factory($valueGeneratorValue, $this->get($field))->generate());
                    continue;
                }

                if (is_string($valueGeneratorValue)
                    && stripos($valueGeneratorValue, '{') === 0
                ) {
                    $valueGeneratorValue = $this->get(
                        str_replace(['{', '}'], '', $valueGeneratorValue)
                    );
                } elseif (is_array($valueGeneratorValue)) {
                    foreach ($valueGeneratorValue as &$valueGeneratorVal) {
                        if (is_string($valueGeneratorVal)
                            && stripos($valueGeneratorVal, '{') === 0
                        ) {
                            $valueGeneratorVal = $this->get(
                                str_replace(['{', '}'], '', $valueGeneratorVal)
                            );
                        }
                    }
                }

                $this->setField($field, ValueGenerator::factory($valueGeneratorKey, $this->get($field), $valueGeneratorValue)->generate());
            }
        }

        return $this;
    }

    /**
     * Sets null values
     *
     * @param array $fields
     *
     * @return AbstractSaveModel
     */
    private function _setNulls(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $this->getFields())
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_ALLOW_NULL, $info[$field])
                || $info[$field][self::FIELD_ALLOW_NULL] !== true
                || $this->get($field)
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
     * @param array $fields
     *
     * @return AbstractSaveModel
     */
    private function _setId(array $fields)
    {
        if (array_key_exists(self::PK_FIELD, $fields)) {
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

            $this->_setFieldsForDbBeforeSave();

            if ($this->getId()) {
                $this->_update();
            } else {
                $this->_create();
            }

            $this->getDb()->reset();

            $this->afterSave();
        } catch (\Exception $e) {
            $this->_onSaveFailure($e);
        }

        return $this;
    }

    /**
     * Creates a new record in DB
     */
    private function _create()
    {
        $this->set([self::PK_FIELD => (int)$this->getDb()->insert()]);
    }

    /**
     * Updates the record in DB
     */
    private function _update()
    {
        $this->getDb()
            ->setWhere('id = :id')
            ->addParameter('id', $this->getId())
            ->update();
    }

    /**
     * @param $data
     * @param $where
     * @param $parameters
     *
     * @return AbstractModel
     */
    protected function updateMany($data, $where, $parameters = [])
    {
        $db = $this->getDb();

        $db->setWhere($where);
        if (count($parameters) > 0) {
            foreach ($parameters as $parameterKey => $parameterValue) {
                $db->addParameter($parameterKey, $parameterValue);
            }
        }

        foreach ($data as $field => $parameter) {
            $db->addField($field);
            $db->addParameter($field, $parameter);
        }

        $db->update();

        return $this;
    }

    /**
     * Sets fields for DB
     *
     * @return AbstractModel
     */
    private function _setFieldsForDbBeforeSave()
    {
        $info = $this->getFieldsInfo();
        $db = $this->getDb();

        foreach ($info as $field => $fieldInfo) {
            $db->addField($field);

            if (!array_key_exists(self::FIELD_TYPE, $fieldInfo)) {
                $db->addParameter($field, $this->get($field));
                continue;
            }

            switch ($fieldInfo[self::FIELD_TYPE]) {
                case self::FIELD_TYPE_BOOL:
                    $db->addParameter($field, ValueGenerator::factory(ValueGenerator::BOOL_INT, $this->get($field))->generate());
                    break;
                case self::FIELD_TYPE_STRING:
                    $db->addParameter($field, ValueGenerator::factory(ValueGenerator::STRING, $this->get($field))->generate());
                    break;
                case self::FIELD_TYPE_DATETIME:
                    $db->addParameter(
                        $field,
                        ValueGenerator::factory(ValueGenerator::DATETIME_AS_STRING, $this->get($field)->generate())
                    );
                    break;
                default:
                    $db->addParameter($field, $this->get($field));
                    break;
            }
        }

        return $this;
    }

    /**
     * Runs after saving
     */
    protected function afterSave()
    {
    }

    /**
     * On save failure
     *
     * @param \Exception $e
     *
     * @throws ModelException
     */
    private function _onSaveFailure(\Exception $e)
    {
        $info = $this->getFieldsInfo();
        $fields = [];

        foreach ($info as $field => $fieldInfo) {
            $value = $this->get($field);

            if (is_object($value)) {
                continue;
            }

            if (is_bool($value)) {
                $value = (int)$value;
            }

            $fields[] = sprintf('%s: %s', $field, $value);
        }

        throw new ModelException(
            '{e}. Unable to save the model {class} with the fields: {fields}',
            [
                'e'      => $e->getMessage(),
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

            $this->addErrors($field, App::getInstance()->getValidator()->validate($this->get($field), $rules)->getErrors());
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
            } else {
                $parsedErrors[$key] = App::getInstance()->getLanguage()->getMessage('validation', $values[0]);
            }
        }

        return $parsedErrors;
    }

    /**
     * Gets validation rules for field
     *
     * @param string $field
     *
     * @return array
     *
     * @throws ModelException
     */
    public final function getValidationRulesForField($field)
    {
        $info = $this->getFieldsInfo();
        if (!array_key_exists($field, $info)) {
            throw new ModelException(
                'Unable to find field: {field} for model: {model}',
                [
                    'field' => $field,
                    'model' => get_class($this)
                ]
            );
        }

        if (!array_key_exists(self::FIELD_VALIDATION, $info[$field])) {
            return [];
        }

        $rules = [];
        foreach ($info[$field][self::FIELD_VALIDATION] as $key => $value) {
            if (!is_string($key)) {
                $key = $value;
            }

            $rules[$key] = $value;
        }

        return $rules;
    }

    /**
     * Runs before saving
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
            if (array_key_exists(self::FIELD_BEFORE_SAVE, $parameters)) {
                foreach ($parameters[self::FIELD_BEFORE_SAVE] as $key => $value) {
                    if (is_string($key)) {
                        $method = $key;
                        if (method_exists($this, $method)) {
                            $this->setField($field, $this->$method($this->get($field), $value));
                        }
                    } else {
                        $method = $value;
                        if (method_exists($this, $method)) {
                            $this->setField($field, $this->$method($this->get($field)));
                        }
                    }
                }
            }

            if (array_key_exists(self::FIELD_UNIQUE, $parameters)) {
                $model = $this->exceptId($this->getId())->checkUnique($field)->find();
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
     * @param string $field
     *
     * @return AbstractModel
     */
    protected function checkUnique($field)
    {
        $this->getDb()->addWhere(sprintf('%s.%s = :field', Db::DEFAULT_ALIAS, $field));
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
            if (!array_key_exists(self::FIELD_RELATION, $relationInfo)) {
                continue;
            }

            /*
                * @var AbstractModel $relationModel
             */
            $relationName = $this->getRelationName($field);
            $relationModelName = $relationInfo[self::FIELD_RELATION];

            if ($this->get($relationName) instanceof $relationModelName === false) {
                $relationModel = $this->getModelByName($relationModelName);

                if ($this->get($field) !== 0) {
                    $relationModel = $relationModel->byId($this->get($field))->find();

                    if (!$relationModel instanceof $relationModelName) {
                        throw new ModelException(
                            'Unable to find relation with name: {name} by id: {id}',
                            [
                                'name' => $relationName,
                                'id'   => $this->get($field)
                            ]
                        );
                    }
                }
            } else {
                $relationModel = $this->get($relationName);
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
            if (!array_key_exists(self::FIELD_RELATION_TO_PARENT, $fieldInfo)) {
                continue;
            }

            $value = $this->get($field);

            if (array_key_exists(self::FIELD_ALLOW_NULL, $fieldInfo)
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
            $model = new $modelName;
            if (!$model instanceof AbstractModel
                || !$model->byId($value)->find() instanceof AbstractModel
            ) {
                throw new ModelException(
                    'Unable to find model: {model} with ID = {id}',
                    [
                        'model' => $modelName,
                        'id'    => $value
                    ]
                );
            }
        }

        return $this;
    }
}
