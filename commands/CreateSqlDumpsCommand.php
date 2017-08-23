<?php

namespace testS\commands;

use testS\components\Db;
use testS\components\exceptions\MigrationException;

/**
 * Create dumps command
 *
 * @package testS\commands
 */
class CreateSqlDumpsCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		self::createDumps();
	}

	/**
	 * Clear DB script
	 */
	public static function createDumps()
	{
        Db::setSystemPdo();

		$sites = Db::fetchAll("SELECT * " . "FROM `sites`");

		foreach ($sites as $site) {
			Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"]);

			exec(
				sprintf(
					"mysqldump -u %s -p%s -h %s %s | gzip -c > %s/%s.sql.gz",
					$site["dbUser"],
					$site["dbPassword"],
					$site["dbHost"],
					$site["dbName"],
					__DIR__ . "/../backups",
					$site["dbName"]
				)
			);
		}
	}
}