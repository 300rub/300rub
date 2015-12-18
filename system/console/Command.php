<?php

namespace system\console;

/**
 * Abstract command class
 *
 * @package system.console
 */
abstract class Command
{

	/**
	 * Runs command
	 *
	 * @param string[] $args Arguments
	 *
	 * @return bool
	 */
	abstract public function run($args);
}