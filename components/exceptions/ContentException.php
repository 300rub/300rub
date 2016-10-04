<?php

namespace testS\components\exceptions;

/**
 * ContentException class file
 *
 * @package testS\components
 */
class ContentException extends AbstractException
{

	/**
	 * Get error code
	 *
	 * @return integer
	 */
	protected function getErrorCode()
	{
		return 204;
	}

	/**
	 * Get log name
	 *
	 * @return string
	 */
	protected function getLogName()
	{
		return "content.log";
	}
}