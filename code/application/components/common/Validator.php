<?php

namespace ss\application\components\common;

use ss\application\App;

/**
 * Class for validation model's fields
 */
class Validator
{

    /**
     * Types
     */
    const TYPE_REQUIRED = 'required';
    const TYPE_ALIAS = 'alias';
    const TYPE_MAX_LENGTH = 'maxLength';
    const TYPE_MIN_LENGTH = 'minLength';
    const TYPE_MIN_VALUE = 'minValue';
    const TYPE_IP = 'ip';
    const TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN = 'latinDigitUnderscoreHyphen';
    const TYPE_EMAIL = 'email';
    const TYPE_UNIQUE = 'unique';

    /**
     * Type list
     *
     * @var array
     */
    private $_typeList = [
        self::TYPE_REQUIRED
            => 'checkRequired',
        self::TYPE_ALIAS
            => 'checkAlias',
        self::TYPE_MAX_LENGTH
            => 'checkMaxLength',
        self::TYPE_MIN_LENGTH
            => 'checkMinLength',
        self::TYPE_MIN_VALUE
            => 'checkMinValue',
        self::TYPE_IP
            => 'checkIp',
        self::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN
            => 'checkLatinDigitUnderscoreHyphen',
        self::TYPE_EMAIL
            => 'checkEmail',
    ];

    /**
     * Value
     *
     * @var string
     */
    private $_value;

    /**
     * Rule value
     *
     * @var mixed
     */
    private $_ruleValue = null;

    /**
     * Errors
     *
     * @var array
     */
    private $_errors = [];

    /**
     * Validates
     *
     * @param mixed $value Value
     * @param array $rules Rules
     *
     * @return Validator
     */
    public function validate($value, $rules)
    {
        $this->_errors = [];
        $this->_value = $value;

        foreach ($rules as $key => $value) {
            if (array_key_exists($key, $this->_typeList) === false) {
                continue;
            }

            $this->_ruleValue = $value;

            $method = $this->_typeList[$key];
            $this->$method();
        }

        return $this;
    }

    /**
     * Gets errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Adds error
     *
     * @param string $value Value
     *
     * @return Validator
     */
    private function _addError($value)
    {
        if (in_array($value, $this->_errors) === false) {
            $this->_errors[] = $value;
        }

        return $this;
    }

    /**
     * Verifies required
     *
     * @return void
     */
    protected function checkRequired()
    {
        if (empty($this->_value) === true) {
            $this->_addError(self::TYPE_REQUIRED);
        }
    }

    /**
     * Verifies string length for max value
     *
     * @return void
     */
    protected function checkMaxLength()
    {
        if (mb_strlen($this->_value) > $this->_ruleValue) {
            $this->_addError(self::TYPE_MAX_LENGTH);
        }
    }

    /**
     * Verifies string length for min value
     *
     * @return void
     */
    protected function checkMinLength()
    {
        if (mb_strlen($this->_value) < $this->_ruleValue) {
            $this->_addError(self::TYPE_MIN_LENGTH);
        }
    }

    /**
     * Verifies min value
     *
     * @return void
     */
    protected function checkMinValue()
    {
        if ($this->_value < $this->_ruleValue) {
            $this->_addError(self::TYPE_MIN_VALUE);
        }
    }

    /**
     * Verifies alias
     *
     * @return void
     */
    protected function checkAlias()
    {
        if (empty($this->_value) === true
            || (bool)preg_match('/^[0-9a-z-]+$/i', $this->_value) === false
        ) {
            $this->_addError(self::TYPE_ALIAS);
        }
    }

    /**
     * Verifies regex: latin, digit, underscore, hyphen
     *
     * @return void
     */
    protected function checkLatinDigitUnderscoreHyphen()
    {
        if (empty($this->_value) === false
            && (bool)preg_match('/^[0-9a-z-_]+$/i', $this->_value) === false
        ) {
            $this->_addError(self::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN);
        }
    }

    /**
     * Verifies Email
     *
     * @return void
     */
    protected function checkEmail()
    {
        if ((bool)filter_var($this->_value, FILTER_VALIDATE_EMAIL) === false) {
            $this->_addError(self::TYPE_EMAIL);
        }
    }

    /**
     * Verifies IP
     *
     * @return void
     */
    protected function checkIp()
    {
        if ((bool)filter_var($this->_value, FILTER_VALIDATE_IP) === false) {
            $this->_addError(self::TYPE_IP);
        }
    }

    /**
     * Gets all error messages
     *
     * @return array
     */
    public function getErrorMessages()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::TYPE_REQUIRED
                => $language->getMessage('validation', 'required'),
            self::TYPE_MAX_LENGTH
                => $language->getMessage('validation', 'maxLength'),
            self::TYPE_MIN_LENGTH
                => $language->getMessage('validation', 'minLength'),
            self::TYPE_ALIAS
                => $language->getMessage('validation', 'alias'),
            self::TYPE_IP
                => $language->getMessage('validation', 'ip'),
            self::TYPE_EMAIL
                => $language->getMessage('validation', 'email'),
            self::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN
                => $language->getMessage(
                    'validation',
                    'latinDigitUnderscoreHyphen'
                ),
        ];
    }
}
