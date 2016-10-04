<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\MigrationException;
use testS\migrations\M160301000000Sites;
use testS\migrations\M160302000000Migrations;
use Exception;
use testS\models\AbstractModel;

/**
 * Applies migrations
 *
 * @package testS\commands
 */
class MigrateCommand extends AbstractCommand
{

	/**
	 * Is necessary to insert test information
	 * Works only in debug mode
	 *
	 * @var bool
	 */
	public $isTestData = true;

	/**
	 * New migrations
	 *
	 * @var string[]
	 */
	private $_migrations = [];

	/**
	 * All sites
	 *
	 * @var array
	 */
	private $_sites = [];

	/**
	 * Sites witch were backup
	 *
	 * @var array
	 */
	private $_dumpSites = [];

	/**
	 * Not truncate table list
	 *
	 * @var array
	 */
	private static $_notTruncateTableList = [
		"sites",
		"migrations"
	];

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 *
	 * @throws Exception
	 */
	public function run($args = [])
	{
		try {
			$this
				->_checkCommonTables()
				->_setNewMigrations()
				->_setSites();
		} catch (Exception $e) {
			throw $e;
		}

		try {
			$this
				->_applyMigration()
				->_updateVersions();
		} catch (Exception $e) {
			App::console()->output($e->getMessage(), true);
			App::console()->output("DB rollback has been started");

			try {
				$this->_rollbackDumps();
				App::console()->output("All DBs were reverted successfully");
			} catch (Exception $e) {
				throw $e;
			}
		}
	}

	/**
	 * Checks the existence of the main tables
	 *
	 * @return MigrateCommand
	 */
	private function _checkCommonTables()
	{
		if (!Db::isTableExists("sites")) {
			$migration = new M160301000000Sites;
			$migration->up();
			if (App::getApplication()->config->isDebug) {
				$migration->insertData();
			}
		}

		if (!Db::isTableExists("migrations")) {
			$migration = new M160302000000Migrations;
			$migration->up();
		}

		return $this;
	}

	/**
	 * Sets the list of non-applied migrations
	 *
	 * @return MigrateCommand
	 */
	private function _setNewMigrations()
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
					$this->_migrations[] = $version;
				}
			}
		}

		return $this;
	}

	/**
	 * Sets sites
	 *
	 * @return MigrateCommand
	 */
	private function _setSites()
	{
		$rows = Db::fetchAll("SELECT * " . "FROM `sites`");
		foreach ($rows as $row) {
			$this->_sites[] = $row;
		}

		return $this;
	}

	/**
	 * Restores all DB from backups
	 *
	 * @return MigrateCommand
	 *
	 * @throws MigrationException
	 */
	private function _rollbackDumps()
	{
		foreach ($this->_dumpSites as $site) {
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
				"gunzip < " .
				$file .
				" | mysql -u " .
				$site["dbUser"] .
				" -h localhost -p'" .
				$site["dbPassword"] .
				"' " .
				$site["dbName"]
			);
		}

		return $this;
	}

	/**
	 * Applies the migrations
	 *
	 * @throws MigrationException
	 *
	 * @return MigrateCommand
	 */
	private function _applyMigration()
	{
		if (!$this->_migrations || !$this->_sites) {
			return $this;
		}

		sort($this->_migrations);
		foreach ($this->_sites as $site) {
			if (!Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"])) {
				throw new MigrationException(
					"Unable to connect with DB for applying migrations
					with host: {host}, user: {user}, password: {password}, name: {name}",
					[
						"host"     => $site["dbHost"],
						"user"     => $site["dbUser"],
						"password" => $site["dbPassword"],
						"name"     => $site["dbName"],
					]
				);
			}

			foreach ($this->_migrations as $migrationName) {
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

		return $this;
	}

	/**
	 * Version's update
	 *
	 * @return MigrateCommand
	 *
	 * @throws MigrationException
	 */
	private function _updateVersions()
	{
		if (
		!Db::setPdo(
			App::getApplication()->config->db->host,
			App::getApplication()->config->db->user,
			App::getApplication()->config->db->password,
			App::getApplication()->config->db->name
		)
		) {
			throw new MigrationException(
				"Unable to connect with DB for updating versions
					with host: {host}, user: {user}, password: {password}, name: {name}",
				[
					"host"     => App::getApplication()->config->db->host,
					"user"     => App::getApplication()->config->db->user,
					"password" => App::getApplication()->config->db->password,
					"name"     => App::getApplication()->config->db->name,
				]
			);
		}

		try {
			Db::startTransaction();

			foreach ($this->_migrations as $migration) {
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

		return $this;
	}
}