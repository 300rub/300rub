<?php

namespace testS\components\exceptions;

/**
 * CommonException class file
 *
 * @package testS\components
 */
class AccessException extends AbstractException
{

	/**
	 * Get error code
	 *
	 * @return integer
	 */
	protected function getErrorCode()
	{
		return 403;
	}

	/**
	 * Get log name
	 *
	 * @return string
	 */
	protected function getLogName()
	{
		return "access.log";
	}
}