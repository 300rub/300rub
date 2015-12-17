<?php

namespace system\base;

use Exception as E;

/**
 * Exception class file
 *
 * @package system.base
 */
class Exception extends E
{

	/**
	 * Status code
	 *
	 * @var int
	 */
	public $statusCode = 0;

	/**
	 * Constructor
	 *
	 * @param string $message Message
	 * @param int    $status  Status
	 * @param int    $code    Code
	 */
	public function __construct($message, $status = ErrorHandler::DEFAULT_STATUS_CODE, $code = 0)
	{
		$this->statusCode = $status;
		parent::__construct($message, $code);
	}
}