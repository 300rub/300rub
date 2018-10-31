<?php

namespace ss\models\_abstract;

use ss\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractGetModel extends AbstractFindModel
{

    /**
     * Gets one or more fields
     *
     * @param string|string[] $param  Param - key
     * @param string|string[] $except Except keys
     *
     * @return mixed
     *
     * @throws ModelException
     */
    public final function get($param = null, $except = null)
    {
        $fields = $this->getFields();

        if ($param === null) {
            return $this->_getAll($except);
        }

        if (is_array($param) === true) {
            $list = [];
            foreach ($param as $field) {
                if (array_key_exists($field, $fields) === false) {
                    throw new ModelException(
                        'Unable to find the field {field} ' .
                        'from the model {model}',
                        [
                            'field' => $field,
                            'model' => get_class($this)
                        ]
                    );
                }

                $list[$field] = $this->getField($field);
            }

            return $list;
        }

        if (array_key_exists($param, $fields) === false) {
            throw new ModelException(
                'Unable to find field {field} for model {model}',
                [
                    'field' => $param,
                    'model' => get_class($this)
                ]
            );
        }

        if ($this->_isRelation($param) === true) {
            return $this->getRelationModelByFieldName(
                $this->getRelationIdFields($param),
                true
            );
        }

        return $this->getField($param);
    }

    /**
     * Gets all fields
     *
     * @param string|string[] $except Except keys
     *
     * @return array
     */
    private function _getAll($except)
    {
        $fields = $this->getFields();

        if (is_array($except) === false) {
            return $fields;
        }

        $list = [];
        foreach ($fields as $key => $value) {
            if (in_array($key, $except) === false) {
                $list[$key] = $value;
            }
        }

        return $list;
    }

    /**
     * Checks if it's relation field
     *
     * @param string $fieldName Field name
     *
     * @return bool
     */
    private function _isRelation($fieldName)
    {
        if (strlen($fieldName) > 5
            && substr($fieldName, -5) === 'Model'
        ) {
            return true;
        }

        return false;
    }
}
