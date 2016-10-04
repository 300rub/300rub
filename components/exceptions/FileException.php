<?php

namespace testS\components\exceptions;

/**
 * FileException class file
 *
 * @package testS\components
 */
class FileException extends AbstractException
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
		return "file.log";
	}
}