<?php

namespace testS\components\exceptions;

/**
 * SshException class file
 *
 * @package testS\components
 */
class SshException extends AbstractException
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
		return "ssh.log";
	}
}