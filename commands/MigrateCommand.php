<?php

namespace commands;

use system\App;
use system\base\Exception;
use system\base\Logger;
use system\console\Command;
use system\db\Db;
use system\db\repository_tables\Migrations;
use system\db\repository_tables\Sites;

/**
 * Applies migrations
 *
 * @package commands
 */
class MigrateCommand extends Command
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
	 * @return bool
	 */
	public function run($args = [])
	{
		if (!$this->_checkCommonTables()) {
			Logger::log("Basic tables are not found", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		Logger::log("Start to run migrations", Logger::LEVEL_INFO, "console.build");

		if (App::console()->config->isDebug) {
			Logger::log("Cleaning database will be before performing", Logger::LEVEL_INFO, "console.migrate");
			if ($this->isTestData) {
				Logger::log("Inserting test data will be ", Logger::LEVEL_INFO, "console.migrate");
			}
		}

		if (!$this->_setNewMigrations()) {
			Logger::log("Unable to determine migrations", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_setSites()) {
			Logger::log("Unable to determine sites", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_createDumps()) {
			Logger::log("Unable to create backup dumps", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_applyMigration() || !$this->_updateVersions()) {
			Logger::log("Failed to apply migrations", Logger::LEVEL_ERROR, "console.migrate");

			if ($this->_rollbackDumps()) {
				Logger::log("All databases were successfully rollback", Logger::LEVEL_INFO, "console.migrate");
			} else {
				Logger::log("Unable to rollback databases!!!", Logger::LEVEL_ERROR, "console.migrate");
			}

			return false;
		}

		Logger::log("All migration successfully applied", Logger::LEVEL_INFO, "console.migrate");
		return true;
	}

	/**
	 * Checks the existence of the main tables
	 *
	 * @return bool
	 */
	private function _checkCommonTables()
	{
		if (!Db::isTableExists("migrations")) {
			try {
				$migration = new Migrations;
				if (!$migration->up()) {
					return false;
				}
			} catch (Exception $e) {
				Logger::log(
					"Unable to create table \"migrations\" " . App::console()->config->db->name,
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
				return false;
			}
		}

		if (!Db::isTableExists("sites")) {
			try {
				$migration = new Sites;
				if (!$migration->up()) {
					return false;
				}
				if (App::console()->config->isDebug && !$migration->insertData()) {
					return false;
				}
			} catch (Exception $e) {
				Logger::log(
					"Unable to create table \"sites\"" . App::console()->config->db->name,
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
				return false;
			}
		}

		return true;
	}

	/**
	 * Sets the list of non-applied migrations
	 *
	 * @return bool
	 */
	private function _setNewMigrations()
	{
		$versions = [];
		$rows = Db::fetchAll("SELECT * FROM `migrations`");
		foreach ($rows as $row) {
			$versions[] = $row["version"];
		}

		$handle = opendir(__DIR__ . "/../migrations");
		if (!$handle) {
			Logger::log("Unable to open folder with migrations", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$version = str_replace(".php", "", $file);
				if (App::console()->config->isDebug || !in_array($version, $versions)) {
					$this->_migrations[] = $version;
				}
			}
		}

		return true;
	}

	/**
	 * Sets sites
	 *
	 * @return bool
	 */
	private function _setSites()
	{
		$rows = Db::fetchAll("SELECT * FROM `sites`");
		foreach ($rows as $row) {
			if (!App::console()->config->isDebug) {
				$row["db_name"] = $row["db_name"];
			}
			$this->_sites[] = $row;
		}

		return true;
	}

	/**
	 * Makes backup dumps for all DB
	 *
	 * @return bool
	 */
	private function _createDumps()
	{
		foreach ($this->_sites as $site) {
			if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
				Logger::log(
					"Unable to connect with DB \"" . $site["db_name"] . "\"",
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
				return false;
			}

			$this->_dumpSites[] = $site;

			exec(
				"mysqldump -u " .
				$site["db_user"] .
				" -h localhost -p'" .
				$site["db_password"] .
				"' " .
				$site["db_name"] .
				" | gzip -c > " .
				__DIR__ .
				"/../backups/" .
				$site["db_name"] .
				".sql.gz"
			);
		}

		return true;
	}

	/**
	 * Restores all DB from backups
	 *
	 * @return bool
	 */
	private function _rollbackDumps()
	{
		foreach ($this->_dumpSites as $site) {
			$file = __DIR__ . "/../backups/" . $site["db_name"] . ".sql.gz";
			if (!file_exists($file)) {
				Logger::log(
					"Unable to find the dump file of DB \"" . $site["db_name"] . "\"",
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
				return false;
			}

			exec(
				"gunzip < " .
				$file .
				" | mysql -u " .
				$site["db_user"] .
				" -h localhost -p'" .
				$site["db_password"] .
				"' " .
				$site["db_name"]
			);
		}

		return true;
	}

	/**
	 * Applies the migrations
	 *
	 * @return bool
	 */
	private function _applyMigration()
	{
		if (!$this->_migrations) {
			Logger::log("There are not non-applied migrations", Logger::LEVEL_INFO, "console.migrate");
			return true;
		}

		if (!$this->_sites) {
			Logger::log("Sites are not found", Logger::LEVEL_INFO, "console.migrate");
			return true;
		}

		sort($this->_migrations);

		try {
			foreach ($this->_sites as $site) {
				if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
					Logger::log(
						"Unable to connect with DB \"" . $site["db_name"] . "\"",
						Logger::LEVEL_ERROR,
						"console.migrate"
					);
					return false;
				}

				if (App::console()->config->isDebug) {
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
							&& !Db::execute("DROP TABLE `{$table}`")
						) {
							Logger::log(
								"Unable to delete table {$table} from DB " . $site["db_name"],
								Logger::LEVEL_ERROR,
								"console.migrate"
							);
							return false;
						}
					}

					Logger::log(
						"DB \"" . $site["db_name"] . "\" was successfully cleaned",
						Logger::LEVEL_INFO,
						"console.migrate"
					);
				}

				foreach ($this->_migrations as $migrationName) {
					/**
					 * @var \system\db\Migration $migration
					 */
					$migrationFullName = "\\migrations\\{$migrationName}";
					$migration = new $migrationFullName;
					if (!$migration->up()) {
						Logger::log(
							"Unable to apply migration \"{$migrationName}\" for DB \"" . $site["db_name"] . "\"",
							Logger::LEVEL_ERROR,
							"console.migrate"
						);
						return false;
					}
					Logger::log(
						"Migration \"{$migrationName}\" was applied successfully",
						Logger::LEVEL_INFO,
						"console.migrate"
					);
				}

				if (App::console()->config->isDebug && $this->isTestData) {
					$files = array_diff(scandir(__DIR__ . "/../fixtures"), ['..', '.']);
					foreach ($files as $file) {
						$tableName = str_replace(".php", "", $file);
						$records = require(__DIR__ . "/../fixtures/" . $file);

						foreach ($records as $record) {
							$columns = [];
							$values = [];
							$substitutions = [];

							foreach ($record as $field => $value) {
								$columns[] = $field;
								$substitutions[] = "?";
								$values[] = $value;
							}

							$query =
								"INSERT INTO " .
								$tableName .
								" (" .
								implode(",", $columns) .
								") VALUES (" .
								implode(",", $substitutions) .
								")";
							if (!Db::execute($query, $values)) {
								Logger::log(
									"Unable to insert test information in migration for DB \"" .
									$site["db_name"] .
									"\"",
									Logger::LEVEL_ERROR,
									"console.migrate"
								);
								return false;
							}
						}
					}
					Logger::log(
						"Test information for migration was for DB \"" . $site["db_name"] . "\" successfully inserted",
						Logger::LEVEL_INFO,
						"console.migrate"
					);
				}
			}
		} catch (Exception $e) {
			return false;
		}

		if (App::console()->config->isDebug) {
			if (
			!Db::setPdo(
				App::console()->config->db->user,
				App::console()->config->db->password,
				App::console()->config->db->name
			)
			) {
				return false;
			}

			if (!Db::execute("TRUNCATE TABLE `migrations`")) {
				Logger::log("Unable to truncate table \"migrations\"", Logger::LEVEL_ERROR, "console.migrate");
				return false;
			}
		}

		return true;
	}

	/**
	 * Version's update
	 *
	 * @return bool
	 */
	private function _updateVersions()
	{
		if (
		!Db::setPdo(
			App::console()->config->db->user,
			App::console()->config->db->password,
			App::console()->config->db->name
		)
		) {
			Logger::log("Unable to connect with the main DB", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		Db::startTransaction();
		foreach ($this->_migrations as $migration) {
			if (!Db::execute("INSERT INTO `migrations` (version) VALUES(?)", [$migration])) {
				Db::rollbackTransaction();

				Logger::log("Unable to update version of migrations", Logger::LEVEL_ERROR, "console.migrate");
				return false;
			}
		}

		Db::commitTransaction();
		return true;
	}
}