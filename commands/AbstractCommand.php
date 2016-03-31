<?php

namespace commands;

/**
 * Abstract command class
 *
 * @package commands
 */
abstract class AbstractCommand
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