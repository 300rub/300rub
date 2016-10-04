<?php

namespace testS\commands;

use testS\components\Db;
use testS\components\exceptions\MigrationException;

/**
 * Rollback Sql dumps command
 *
 * @package testS\commands
 */
class RollbackSqlDumpsCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		self::rollbackDumps();
	}

	/**
	 * Clear DB script
	 */
	public static function rollbackDumps()
	{
		$sites = Db::fetchAll("SELECT * " . "FROM `sites`");

		foreach ($sites as $site) {
			if (!Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"])) {
				throw new MigrationException(
					"Unable to set PDO for creating dump
					with host: {host}, user: {user}, password: {password}, name: {name}",
					[
						"host"     => $site["dbHost"],
						"user"     => $site["dbUser"],
						"password" => $site["dbPassword"],
						"name"     => $site["dbName"],
					]
				);
			}

			$file = __DIR__ . "/../backups/" . $site["dbName"] . ".sql.gz";
			if (!file_exists($file)) {
				throw new MigrationException(
					"Unable to find the dump file for DB: {db}",
					[
						"db" => $site["dbName"]
					]
				);
			}

			exec(
				sprintf(
					"gunzip < %s | mysql -u %s -p%s -h %s %s",
					$file,
					$site["dbUser"],
					$site["dbPassword"],
					$site["dbHost"],
					$site["dbName"]
				)
			);
		}
	}
}