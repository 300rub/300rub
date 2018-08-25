<?php

namespace ss\models\_abstract;

use ss\application\App;
use ss\application\components\common\Validator;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractSaveModel extends AbstractSaveRelationModel
{

    /**
     * Saves model in DB
     *
     * @throws ModelException
     *
     * @return AbstractModel|AbstractSaveModel
     */
    public final function save()
    {
        $this->clearErrors();
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

            $this->afterSave();

            $this->resetTable();
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
        $this->set([self::PK_FIELD => (int)$this->getTable()->insert()]);
    }

    /**
     * Updates the record in DB
     *
     * @return void
     */
    private function _update()
    {
        $this->getTable()
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
     * @return AbstractModel|AbstractSaveModel
     */
    protected function updateMany(array $data, $where, $parameters = [])
    {
        $table = $this->getTable();

        $table->setWhere($where);
        if (count($parameters) > 0) {
            foreach ($parameters as $parameterKey => $parameterValue) {
                $table->addParameter($parameterKey, $parameterValue);
            }
        }

        foreach ($data as $field => $parameter) {
            $table->addField($field);
            $table->addParameter($field, $parameter);
        }

        $table->update();

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
        $table = $this->getTable();
        $valueGenerator = App::getInstance()->getValueGenerator();

        foreach ($info as $field => $fieldInfo) {
            $table->addField($field);

            if (array_key_exists(self::FIELD_TYPE, $fieldInfo) === false) {
                $table->addParameter($field, $this->get($field));
                continue;
            }

            switch ($fieldInfo[self::FIELD_TYPE]) {
                case self::FIELD_TYPE_BOOL:
                    $table->addParameter(
                        $field,
                        $valueGenerator->getValue(
                            ValueGenerator::BOOL_INT,
                            $this->get($field)
                        )
                    );
                    break;
                case self::FIELD_TYPE_STRING:
                    $table->addParameter(
                        $field,
                        $valueGenerator->getValue(
                            ValueGenerator::STRING,
                            $this->get($field)
                        )
                    );
                    break;
                case self::FIELD_TYPE_DATETIME:
                    $table->addParameter(
                        $field,
                        $valueGenerator->getValue(
                            ValueGenerator::DATETIME_AS_STRING,
                            $this->get($field)
                        )
                    );
                    break;
                default:
                    $table->addParameter($field, $this->get($field));
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
        $this->afterChange();
    }

    /**
     * Runs after changing
     *
     * @return void
     */
    protected function afterChange()
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
     * Runs before saving
     *
     * @return void
     */
    protected function beforeSave()
    {
        $this
            ->_setFieldsBeforeSave()
            ->setRelationsBeforeSave()
            ->checkParentsBeforeSave();
    }

    /**
     * Sets fields before save
     *
     * @return AbstractModel|AbstractSaveModel
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
                $model = $this->getNewModel()
                    ->exceptId($this->getId())
                    ->checkUnique($field)
                    ->find();
                if ($model !== null) {
                    $this->addErrors($field, [Validator::TYPE_UNIQUE]);
                }
            }
        }

        return $this;
    }
}
