<?php

namespace testS\commands;

/**
 * Abstract command class
 *
 * @package testS\commands
 */
abstract class AbstractCommand
{

	/**
	 * Runs command
	 *
	 * @param string[] $args Arguments
	 */
	abstract public function run($args);
}