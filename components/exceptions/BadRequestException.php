<?php

namespace testS\components\exceptions;

/**
 * BadRequestException class file
 *
 * @package testS\components
 */
class BadRequestException extends AbstractException
{

	/**
	 * Get error code
	 *
	 * @return integer
	 */
	protected function getErrorCode()
	{
		return 400;
	}

	/**
	 * Get log name
	 *
	 * @return string
	 */
	protected function getLogName()
	{
		return "badRequest.log";
	}
}