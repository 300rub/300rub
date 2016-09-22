<?php

namespace commands;

use applications\App;
use components\Db;
use components\exceptions\MigrationException;
use migrations\M_160301_000000_sites;
use migrations\M_160302_000000_migrations;
use Exception;

/**
 * Applies migrations
 *
 * @package commands
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
				->_setSites()
				->_createDumps();
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
			$migration = new M_160301_000000_sites;
			$migration->up();
			if (App::getApplication()->config->isDebug) {
				$migration->insertData();
			}
		}

		if (!Db::isTableExists("migrations")) {
			$migration = new M_160302_000000_migrations;
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
			if (strpos($file, "M_") !== false) {
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
	 * Makes backup dumps for all DB
	 *
	 * @throws MigrationException
	 *
	 * @return MigrateCommand
	 */
	private function _createDumps()
	{
		foreach ($this->_sites as $site) {
			if (!Db::setPdo($site["dbHost"], $site["dbUser"], $site["db_password"], $site["db_name"])) {
				throw new MigrationException(
					"Unable to set PDO for creating dump
					with host: {host}, user: {user}, password: {password}, name: {name}",
					[
						"host"     => $site["dbHost"],
						"user"     => $site["dbUser"],
						"password" => $site["db_password"],
						"name"     => $site["db_name"],
					]
				);
			}

			$this->_dumpSites[] = $site;
			$backupsFolder = __DIR__ . "/../backups";
			if (!file_exists($backupsFolder)) {
				mkdir($backupsFolder, 0777);
			}

			exec(
				"mysqldump -u " .
				$site["dbUser"] .
				" -h localhost -p'" .
				$site["db_password"] .
				"' " .
				$site["db_name"] .
				" | gzip -c > " .
				$backupsFolder .
				"/" .
				$site["db_name"] .
				".sql.gz"
			);
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
			$file = __DIR__ . "/../backups/" . $site["db_name"] . ".sql.gz";
			if (!file_exists($file)) {
				throw new MigrationException(
					"Unable to find the dump file for DB: {db}",
					[
						"db" => $site["db_name"]
					]
				);
			}

			exec(
				"gunzip < " .
				$file .
				" | mysql -u " .
				$site["dbUser"] .
				" -h localhost -p'" .
				$site["db_password"] .
				"' " .
				$site["db_name"]
			);
		}

		return $this;
	}

	/**
	 * Clear DB
	 *
	 * @param array $site
	 *
	 * @return MigrateCommand
	 *
	 * @throws MigrationException
	 */
	private function _clearDb(array $site)
	{
		$tables = [];

		$rows = Db::fetchAll("SHOW TABLES FROM " . $site["db_name"]);
		foreach ($rows as $row) {
			foreach ($row as $key => $value) {
				$tables[] = $value;
			}
		}

		foreach ($tables as $table) {
			if (
				$table !== "migrations"
				&& $table !== "sites"
				&& !Db::execute("DROP" . " TABLE `{$table}`")
			) {
				throw new MigrationException(
					"Unable to delete table: {table} from DB: {db}",
					[
						"table" => $table,
						"db"    => $site["db_name"]
					]
				);
			}
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
			if (!Db::setPdo($site["dbHost"], $site["dbUser"], $site["db_password"], $site["db_name"])) {
				throw new MigrationException(
					"Unable to connect with DB for applying migrations
					with host: {host}, user: {user}, password: {password}, name: {name}",
					[
						"host"     => $site["dbHost"],
						"user"     => $site["dbUser"],
						"password" => $site["db_password"],
						"name"     => $site["db_name"],
					]
				);
			}

			if (App::getApplication()->config->isDebug) {
				$this->_clearDb($site);
			}

			foreach ($this->_migrations as $migrationName) {
				/**
				 * @var \migrations\AbstractMigration $migration
				 */
				$migrationFullName = "\\migrations\\{$migrationName}";
				$migration = new $migrationFullName;
				if (!$migration->isSkip) {
					$migration->up();
				}
			}

			if (App::getApplication()->config->isDebug && $this->isTestData) {
				self::loadFixtures();
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

	/**
	 * Loads fixtures
	 *
	 * @param string $table
	 *
	 * @throws MigrationException
	 */
	public static function loadFixtures($table = null)
	{
		App::console()->output("Fixtures loading  has been started");

		$siteId = App::getApplication()->config->siteId;

		// Files
		$uploadFilesFolder = __DIR__ . "/../public/upload/{$siteId}";
		exec("rm -r {$uploadFilesFolder}");
		$copyFilesFolder = __DIR__ . "/../fixtures/files";
		if (!file_exists(__DIR__ . "/../public/upload")) {
			mkdir(__DIR__ . "/../public/upload", 0777);
		}
		exec("cp -r {$copyFilesFolder} {$uploadFilesFolder}");
		chmod($uploadFilesFolder, 0777);

		// DB
		$files = array_diff(scandir(__DIR__ . "/../fixtures"), ["..", ".", "files"]);
		foreach ($files as $file) {
			$tableName = str_replace(".php", "", $file);

			if ($table !== null && $table !== $tableName) {
				continue;
			}

			$records = require(__DIR__ . "/../fixtures/" . $file);

			if (!Db::execute("TRUNCATE TABLE `{$tableName}`")) {
				throw new MigrationException(
					"Unable to truncate table: {table} while loading fixtures",
					[
						"table" => $tableName
					]
				);
			}

			foreach ($records as $id => $record) {
				$columns = ["id"];
				$values = [$id];
				$substitutions = ["?"];

				foreach ($record as $field => $value) {
					$columns[] = $field;
					$substitutions[] = "?";
					$values[] = $value;
				}

				$query =
					"INSERT" .
					" INTO " .
					$tableName .
					" (" .
					implode(",", $columns) .
					") VALUES (" .
					implode(",", $substitutions) .
					")";
				if (!Db::execute($query, $values)) {
					throw new MigrationException(
						"Unable to load fixtures for table: {table}",
						[
							"table" => $tableName
						]
					);
				}
			}
		}

		App::console()->output("All fixtures have been successfully loaded");
	}
}