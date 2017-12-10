<?php

namespace testS\components;

/**
 * Class for validation model's fields
 *
 * @package testS\components
 */
class Validator
{

	/**
	 * Types
	 */
	const TYPE_REQUIRED = "required";
	const TYPE_URL = "url";
	const TYPE_MAX_LENGTH = "maxLength";
	const TYPE_MIN_LENGTH = "minLength";
	const TYPE_MIN_VALUE = "minValue";
	const TYPE_IP = "ip";
	const TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN = "latinDigitUnderscoreHyphen";
	const TYPE_EMAIL = "email";
	const TYPE_UNIQUE = "unique";

	/**
	 * Value
	 *
	 * @var string
	 */
	private $_value;

	/**
	 * Rules
	 *
	 * @var array
	 */
	private $_rules = [];

	/**
	 * Errors
	 *
	 * @var array
	 */
	private $_errors = [];

	/**
	 * Constructor
	 *
	 * @param string $value
	 * @param array  $rules
	 */
	public function __construct($value, $rules)
	{
		$this->_value = $value;
		$this->_rules = $rules;
	}

	/**
	 * Validation
	 *
	 * @return Validator
	 */
	public function validate()
	{
		foreach ($this->_rules as $key => $value) {
			switch ($key) {
				case self::TYPE_REQUIRED:
					$this->_checkRequired();
					break;
				case self::TYPE_MIN_LENGTH:
					$this->_checkMinLength($value);
					break;
				case self::TYPE_MIN_VALUE:
					$this->_checkMinValue($value);
					break;
				case self::TYPE_MAX_LENGTH:
					$this->_checkMaxLength($value);
					break;
				case self::TYPE_URL:
					$this->_checkUrl();
					break;
				case self::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN:
					$this->_checkLatinDigitUnderscoreHyphen();
					break;
				case self::TYPE_EMAIL:
					$this->_checkEmail();
					break;
				case self::TYPE_IP:
					$this->_checkIp();
					break;
				default:
					break;
			}
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
		if (!in_array($value, $this->_errors)) {
			$this->_errors[] = $value;
		}

		return $this;
	}

	/**
	 * Verifies required
	 *
	 * @return void
	 */
	private function _checkRequired()
	{
		if (!$this->_value) {
			$this->_addError(self::TYPE_REQUIRED);
		}
	}

	/**
	 * Verifies string length for max value
	 *
	 * @param int  $max   Max value
	 *
	 * @return void
	 */
	private function _checkMaxLength($max)
	{
		if (mb_strlen($this->_value) > $max) {
			$this->_addError(self::TYPE_MAX_LENGTH);
		}
	}

	/**
	 * Verifies string length for min value
	 *
	 * @param int $min Min value
	 *
	 * @return void
	 */
	private function _checkMinLength($min)
	{
		if (mb_strlen($this->_value) < $min) {
			$this->_addError(self::TYPE_MIN_LENGTH);
		}
	}

	/**
	 * Verifies min value
	 *
	 * @param int $min
	 *
	 * @return void
	 */
	private function _checkMinValue($min)
	{
		if ($this->_value < $min) {
			$this->_addError(self::TYPE_MIN_VALUE);
		}
	}

	/**
	 * Verifies URL
	 *
	 * @return void
	 */
	private function _checkUrl()
	{
		if (!$this->_value || !preg_match("/^[0-9a-z-]+$/i", $this->_value)) {
			$this->_addError(self::TYPE_URL);
		}
	}

	/**
	 * Verifies regex: latin, digit, underscore, hyphen
	 *
	 * @return void
	 */
	private function _checkLatinDigitUnderscoreHyphen()
	{
		if ($this->_value && !preg_match("/^[0-9a-z-_]+$/i", $this->_value)) {
			$this->_addError(self::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN);
		}
	}

	/**
	 * Verifies Email
	 *
	 * @return void
	 */
	private function _checkEmail()
	{
		if (!filter_var($this->_value, FILTER_VALIDATE_EMAIL)) {
			$this->_addError(self::TYPE_EMAIL);
		}
	}

	/**
	 * Verifies IP
	 *
	 * @return void
	 */
	private function _checkIp()
	{
		if (!filter_var($this->_value, FILTER_VALIDATE_IP)) {
			$this->_addError(self::TYPE_IP);
		}
	}

	/**
	 * Gets all error messages
	 *
	 * @return array
	 */
	public static function getErrorMessages()
	{
		return [
			self::TYPE_REQUIRED                      => Language::t("validation", "required"),
			self::TYPE_MAX_LENGTH                    => Language::t("validation", "maxLength"),
			self::TYPE_MIN_LENGTH                    => Language::t("validation", "minLength"),
			self::TYPE_URL                           => Language::t("validation", "url"),
			self::TYPE_IP                            => Language::t("validation", "ip"),
			self::TYPE_EMAIL                         => Language::t("validation", "email"),
			self::TYPE_UNIQUE                        => Language::t("validation", "unique"),
			self::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN => Language::t("validation", "latinDigitUnderscoreHyphen"),
		];
	}
}