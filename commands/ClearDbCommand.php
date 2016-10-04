<?php

namespace testS\commands;

use testS\applications\App;

/**
 * Applies migrations
 *
 * @package commands
 */
class ClearDbCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		self::clear();
	}

	/**
	 * Clear DB script
	 */
	public static function clear()
	{
		$db = App::getApplication()->config->db;

		exec(
			sprintf(
				'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
				$db->user,
				$db->password,
				$db->host,
				$db->name
			)
		);

		exec(
			sprintf(
				'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
				$db->user,
				$db->password,
				$db->host,
				$db->name
			)
		);
	}
}