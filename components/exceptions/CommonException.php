<?php

namespace testS\components\exceptions;

/**
 * CommonException class file
 *
 * @package testS\components
 */
class CommonException extends AbstractException
{

	/**
	 * Get error code
	 *
	 * @return integer
	 */
	protected function getErrorCode()
	{
		return 500;
	}

	/**
	 * Get log name
	 *
	 * @return string
	 */
	protected function getLogName()
	{
		return "common.log";
	}
}