<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\MigrationException;
use Exception;

/**
 * Applies migrations
 *
 * @package testS\commands
 */
class MigrateCommand extends AbstractCommand
{

	/**
	 * New migrations
	 *
	 * @var string[]
	 */
	private static $_migrations = [];

	/**
	 * All sites
	 *
	 * @var array
	 */
	private static $_sites = [];

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		self::migrate();
	}

	/**
	 * Migrate
	 *
	 * @throws Exception
	 */
	public static function migrate()
	{
		try {
			self::_setNewMigrations();
			self::_setSites();
		} catch (Exception $e) {
			throw $e;
		}

		try {
			self::_applyMigration();
			self::_updateVersions();
		} catch (Exception $e) {
			//App::console()->output($e->getMessage(), true);

			//			try {
			//				App::console()->output("DB rollback has been started");
			//			} catch (Exception $e) {
			//				throw $e;
			//			}
		}
	}

	/**
	 * Sets the list of non-applied migrations
	 */
	private static function _setNewMigrations()
	{
		$versions = [];
		$rows = Db::fetchAll("SELECT * " . "FROM `migrations`");
		foreach ($rows as $row) {
			$versions[] = $row["version"];
		}

		$migrations = opendir(__DIR__ . "/../migrations");
		while (false !== ($file = readdir($migrations))) {
			if (strpos($file, "M") === 0) {
				$version = str_replace(".php", "", $file);
				if (App::getApplication()->config->isDebug || !in_array($version, $versions)) {
					self::$_migrations[] = $version;
				}
			}
		}
	}

	/**
	 * Sets sites
	 */
	private static function _setSites()
	{
		self::$_sites = Db::fetchAll("SELECT * " . "FROM `sites`");
	}

	/**
	 * Applies the migrations
	 *
	 * @throws MigrationException
	 *
	 * @return bool
	 */
	private static function _applyMigration()
	{
		if (!self::$_migrations || !self::$_sites) {
			return false;
		}

		sort(self::$_migrations);
		foreach (self::$_sites as $site) {
			Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"]);

			foreach (self::$_migrations as $migrationName) {
				/**
				 * @var \testS\migrations\AbstractMigration $migration
				 */
				$migrationFullName = "\\testS\\migrations\\{$migrationName}";
				$migration = new $migrationFullName;
				if (!$migration->isSkip) {
					$migration->up();
				}
			}
		}

		return true;
	}

	/**
	 * Version's update
	 *
	 * @throws MigrationException
	 */
	private static function _updateVersions()
	{
		Db::setPdo(
			App::getApplication()->config->db->host,
			App::getApplication()->config->db->user,
			App::getApplication()->config->db->password,
			App::getApplication()->config->db->name
		);

		try {
			Db::startTransaction();

			foreach (self::$_migrations as $migration) {
				if (!Db::execute("INSERT" . " INTO `migrations` (version) VALUES(?)", [$migration])) {
					throw new MigrationException(
						"UUnable to update version with migration: {migration}",
						[
							"migration" => $migration,
						]
					);
				}
			}
		} catch (MigrationException $e) {
			Db::rollbackTransaction();
		}

		Db::commitTransaction();
	}
}