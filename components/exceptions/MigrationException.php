<?php

namespace testS\components\exceptions;

/**
 * MigrationException class file
 *
 * @package components
 */
class MigrationException extends AbstractException
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
		return "migration.log";
	}
}