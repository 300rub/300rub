<?php

namespace testS\models\_abstract;

use testS\application\exceptions\ModelException;

/**
 * Abstract class for working with models
 */
abstract class AbstractGetModel extends AbstractBaseModel
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
            if (is_array($except) === true) {
                $list = [];
                foreach ($fields as $key => $value) {
                    if (in_array($key, $except) === false) {
                        $list[$key] = $value;
                    }
                }

                return $list;
            }

            return $fields;
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

        return $this->getField($param);
    }
}
