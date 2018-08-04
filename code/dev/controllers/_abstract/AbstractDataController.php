<?php

namespace ss\controllers\_abstract;

use ss\application\exceptions\BadRequestException;

/**
 * Abstract class for working with controller data
 */
abstract class AbstractDataController extends AbstractBaseController
{

    /**
     * Check data constants
     */
    const TYPE_INT = 'int';
    const TYPE_ARRAY = 'array';
    const TYPE_BOOL = 'bool';
    const TYPE_STRING = 'string';
    const NOT_EMPTY = 'notEmpty';

    /**
     * Request data
     *
     * @var array
     */
    private $_data = [];

    /**
     * Sets data
     *
     * @param array $data Request data
     *
     * @return AbstractDataController
     */
    public function setData(array $data)
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * Gets data
     *
     * @param string $key Request data key
     *
     * @return mixed
     */
    protected function get($key)
    {
        if (array_key_exists($key, $this->_data) === false) {
            return null;
        }

        return $this->_data[$key];
    }

    /**
     * Checks the data
     *
     * @param array $check Data to check
     *
     * @throws BadRequestException
     *
     * @return AbstractDataController
     */
    protected function checkData(array $check)
    {
        foreach ($check as $field => $options) {
            if (is_array($options) === false) {
                $field = $options;
                $options = [];
            }

            if (array_key_exists($field, $this->_data) === false) {
                throw new BadRequestException(
                    'Unable to find {field} in request',
                    [
                        'field' => $field
                    ]
                );
            }

            $this
                ->_checkInteger($options, $field)
                ->_checkString($options, $field)
                ->_checkBoolean($options, $field)
                ->_checkArray($options, $field)
                ->_checkNotEmpty($options, $field);
        }

        return $this;
    }

    /**
     * Checks integer
     *
     * @param array  $options Options
     * @param string $field   Field
     *
     * @return AbstractDataController
     *
     * @throws BadRequestException
     */
    private function _checkInteger($options, $field)
    {
        $value = $this->get($field);

        if (in_array(self::TYPE_INT, $options) === true
            && is_int($value) === false
        ) {
            throw new BadRequestException(
                'The field type of {field} is not integer',
                [
                    'field' => $field
                ]
            );
        }

        return $this;
    }

    /**
     * Checks string
     *
     * @param array  $options Options
     * @param string $field   Field
     *
     * @return AbstractDataController
     *
     * @throws BadRequestException
     */
    private function _checkString($options, $field)
    {
        $value = $this->get($field);

        if (in_array(self::TYPE_STRING, $options) === true
            && is_string($value) === false
        ) {
            throw new BadRequestException(
                'The field type of {field} is not string',
                [
                    'field' => $field
                ]
            );
        }

        return $this;
    }

    /**
     * Checks boolean
     *
     * @param array  $options Options
     * @param string $field   Field
     *
     * @return AbstractDataController
     *
     * @throws BadRequestException
     */
    private function _checkBoolean($options, $field)
    {
        $value = $this->get($field);

        if (in_array(self::TYPE_BOOL, $options) === true
            && is_bool($value) === false
        ) {
            throw new BadRequestException(
                'The field type of {field} is not bool',
                [
                    'field' => $field
                ]
            );
        }

        return $this;
    }

    /**
     * Checks array
     *
     * @param array  $options Options
     * @param string $field   Field
     *
     * @return AbstractDataController
     *
     * @throws BadRequestException
     */
    private function _checkArray($options, $field)
    {
        $value = $this->get($field);

        if (in_array(self::TYPE_ARRAY, $options) === true
            && is_array($value) === false
        ) {
            throw new BadRequestException(
                'The field {field} is not an array',
                [
                    'field' => $field
                ]
            );
        }

        return $this;
    }

    /**
     * Checks not empty
     *
     * @param array  $options Options
     * @param string $field   Field
     *
     * @return AbstractDataController
     *
     * @throws BadRequestException
     */
    private function _checkNotEmpty($options, $field)
    {
        $value = $this->get($field);

        if (in_array(self::NOT_EMPTY, $options) === true
            && empty($value) === true
        ) {
            throw new BadRequestException(
                'The field {field} can not be empty',
                [
                    'field' => $field
                ]
            );
        }

        return $this;
    }
}
