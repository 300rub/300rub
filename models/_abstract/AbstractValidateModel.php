<?php

namespace testS\models\_abstract;

use testS\application\App;
use testS\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractValidateModel extends AbstractSetFieldModel
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
     * @return AbstractModel|AbstractValidateModel
     */
    protected function clearErrors()
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
     * @return AbstractModel|AbstractValidateModel
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
     * Validates model's fields
     *
     * @return AbstractModel|AbstractValidateModel
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
}
