<?php

namespace components\exceptions;

/**
 * ModelException class file
 *
 * @package components
 */
class ModelException extends AbstractException
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
		return "model.log";
	}
}