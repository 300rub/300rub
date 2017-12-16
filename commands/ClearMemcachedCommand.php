<?php

namespace testS\commands;

use testS\application\App;

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