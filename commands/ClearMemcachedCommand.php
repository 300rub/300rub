<?php

namespace testS\commands;

use testS\applications\App;

/**
 * Clear Memcached command
 *
 * @package testS\commands
 */
class ClearMemcachedCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		App::getInstance()->getMemcached()->flush();
	}
}