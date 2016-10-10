<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\MigrationException;
use testS\migrations\M160301000000Sites;
use testS\migrations\M160302000000Migrations;

/**
 * Clear DB command
 *
 * @package testS\commands
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

		Db::setPdo($db->host, $db->user, $db->password, $db->name);

		$migration = new M160301000000Sites();
		$migration->up();
		$migration->insertData();

		$migration = new M160302000000Migrations();
		$migration->up();
	}
}