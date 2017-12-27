<?php

namespace testS\models\_abstract;

use testS\application\components\ValueGenerator;

/**
 * Abstract class for working with models
 */
abstract class AbstractSetFieldModel extends AbstractSetRelationModel
{

    /**
     * Sets field values
     *
     * @param array $fields Fields
     *
     * @return AbstractModel|AbstractSetFieldModel
     */
    public final function set(array $fields)
    {
        return $this
            ->setRelations($fields)
            ->setRelationsToParent($fields)
            ->_setTypes($fields)
            ->_setValues()
            ->_setNulls($fields)
            ->_setId($fields);
    }

    /**
     * Sets types
     *
     * @param array $fields Fields
     *
     * @return AbstractSetFieldModel
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
     * @return AbstractSetFieldModel
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
     * @return AbstractSetFieldModel
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
     * @return AbstractSetFieldModel
     */
    private function _setNulls(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach (array_keys($fields) as $field) {
            if (array_key_exists($field, $info) === false) {
                continue;
            }

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
     * @return AbstractSetFieldModel
     */
    private function _setId(array $fields)
    {
        if (array_key_exists(self::PK_FIELD, $fields) === true) {
            $this->setField(self::PK_FIELD, (int)$fields[self::PK_FIELD]);
        }

        return $this;
    }
}
