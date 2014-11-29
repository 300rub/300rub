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
 * Файл класса MigrateCommand
 *
 * Применяет миграции
 *
 * @package commands
 */
class MigrateCommand extends Command
{

	/**
	 * Обновление базы полностью
	 */
	const ARG_RESET = "-r";

	/**
	 * Вставка тестовой информации в базу
	 */
	const ARG_DATA = "-d";

	/**
	 * Новые миграции
	 *
	 * @var string[]
	 */
	private $_migrations = array();

	/**
	 * Все сайты
	 *
	 * @var array
	 */
	private $_sites = array();

	/**
	 * Забекапленые сайты
	 *
	 * @var array
	 */
	private $_dumpSites = array();

	/**
	 * Обновлять ли базы полностью
	 *
	 * @var bool
	 */
	private $_isReset = false;

	/**
	 * Загружать ли тестовую информацию
	 *
	 * @var bool
	 */
	private $_isData = false;

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args = array())
	{
		$connection = Db::setConnect(
			App::console()->db["host"],
			App::console()->db["user"],
			App::console()->db["password"],
			App::console()->db["base"],
			App::console()->db["charset"]
		);
		if (!$connection) {
			return false;
		}

		if (!$this->_checkCommonTables()) {
			return false;
		}

		if (in_array(self::ARG_RESET, $args) && App::console()->isDebug) {
			$this->_isReset = true;
		}
		if (in_array(self::ARG_DATA, $args) && App::console()->isDebug) {
			$this->_isData = true;
		}

		if (!$this->_setNewMigrations()) {
			Logger::log("Unable to set migrations", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_setSites()) {
			Logger::log("Unable to set sites", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_createDumps()) {
			Logger::log("Unable to create sql dumps", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_applyMigration() || !$this->_updateVersions()) {
			Logger::log("Unable to apply migrations", Logger::LEVEL_ERROR, "console.migrate");

			$this->_rollbackDumps();
			Logger::log("All db were rollback", Logger::LEVEL_INFO, "console.migrate");

			return false;
		}

		Logger::log("All migrations are applied successfully", Logger::LEVEL_INFO, "console.migrate");
		return true;
	}

	/**
	 * Проверяет наличие основных таблиц
	 *
	 * @return bool
	 */
	private function _checkCommonTables()
	{
		if (!Db::isTableExist("migrations")) {
			try {
				$migration = new Migrations;
				if (!$migration->up()) {
					return false;
				}
			} catch (Exception $e) {
				return false;
			}
		}

		if (!Db::isTableExist("sites")) {
			try {
				$migration = new Sites;
				if (!$migration->up()) {
					return false;
				}
			} catch (Exception $e) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Устанавливает список непримененных миграций
	 *
	 * @return bool
	 */
	private function _setNewMigrations()
	{
		$versions = array();
		$result = mysql_query("SELECT * FROM migrations");
		if ($result) {
			while ($row = mysql_fetch_assoc($result)) {
				$versions[] = $row["version"];
			}
		}

		$dir = App::console()->rootDir . DIRECTORY_SEPARATOR . "migrations";

		$handle = opendir($dir);
		if (!$handle) {
			Logger::log("Migrations folder does not open", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$version = str_replace(".php", "", $file);
				if (!in_array($version, $versions) || $this->_isReset) {
					$this->_migrations[] = $version;
				}
			}
		}

		return true;
	}

	/**
	 * Устанавливает сайты
	 *
	 * @return bool
	 */
	private function _setSites()
	{
		$result = mysql_query("SELECT * FROM sites");
		if ($result) {
			while ($row = mysql_fetch_assoc($result)) {
				$this->_sites[] = $row;
			}
		}

		return true;
	}

	/**
	 * Делает дампы баз данных
	 *
	 * @return bool
	 */
	private function _createDumps()
	{
		foreach ($this->_sites as $site) {
			$connection = Db::setConnect(
				$site["db_host"],
				$site["db_user"],
				$site["db_password"],
				$site["db_name"],
				App::console()->db["charset"]
			);
			if (!$connection) {
				Logger::log(
					"Unable to connect to db \"" . Db::PREFIX . $site["db_name"] . "\"",
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
				return false;
			}

			$this->_dumpSites[] = $site;

			$command =
				"mysqldump -u " .
				$site["db_user"] .
				" -h localhost -p'" .
				$site["db_password"] .
				"' " .
				Db::PREFIX .
				$site["db_name"] .
				" | gzip -c > " .
				App::console()->rootDir .
				"/backups/" .
				$site["db_name"] .
				".sql.gz";
			exec($command);
		}

		return true;
	}

	/**
	 * Восстанавливает дампы баз данных
	 *
	 * @return bool
	 */
	private function _rollbackDumps()
	{
		foreach ($this->_dumpSites as $site) {
			$file = App::console()->rootDir . "/backups/" . $site["db_name"] . ".sql.gz";
			if (!file_exists($file)) {
				Logger::log(
					"Unable to load file for db \"" . Db::PREFIX . $site["db_name"] . "\"",
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
				return false;
			}

			$command =
				"gunzip < " .
				$file .
				" | mysql -u " .
				$site["db_user"] .
				" -h localhost -p'" .
				$site["db_password"] .
				"' " .
				Db::PREFIX .
				$site["db_name"];
			exec($command);
		}

		return true;
	}

	/**
	 * Применяет миграции
	 *
	 * @return bool
	 */
	private function _applyMigration()
	{
		if (!$this->_migrations) {
			Logger::log("There are no new migrations", Logger::LEVEL_INFO, "console.migrate");
			return true;
		}

		if (!$this->_sites) {
			Logger::log("There are no sites", Logger::LEVEL_INFO, "console.migrate");
			return true;
		}

		sort($this->_migrations);

		try {
			foreach ($this->_sites as $site) {
				$connection = Db::setConnect(
					$site["db_host"],
					$site["db_user"],
					$site["db_password"],
					$site["db_name"],
					App::console()->db["charset"]
				);
				if (!$connection) {
					Logger::log(
						"Unable to connect to db \"" . Db::PREFIX . $site["db_name"] . "\"",
						Logger::LEVEL_ERROR,
						"console.migrate"
					);
					return false;
				}

				if ($this->_isReset && App::console()->isDebug) {
					$migrationsDesc = $this->_migrations;
					rsort($migrationsDesc);
					foreach ($migrationsDesc as $migrationName) {
						/**
						 * @var \system\db\Migration $migration
						 */
						$migrationName = "\\migrations\\{$migrationName}";
						$migration = new $migrationName;
						if (!$migration->down()) {
							Logger::log(
								"Unable to down migration \"{$migrationName}\" from db \"" .
								Db::PREFIX .
								$site["db_name"] .
								"\"",
								Logger::LEVEL_ERROR,
								"console.migrate"
							);
							return false;
						}
					}
				}

				foreach ($this->_migrations as $migrationName) {
					/**
					 * @var \system\db\Migration $migration
					 */
					$migrationName = "\\migrations\\{$migrationName}";
					$migration = new $migrationName;
					if (!$migration->up()) {
						Logger::log(
							"Unable to up migration \"{$migrationName}\" from db \"" .
							Db::PREFIX .
							$site["db_name"] .
							"\"",
							Logger::LEVEL_ERROR,
							"console.migrate"
						);
						return false;
					}

					if ($this->_isData && App::console()->isDebug && !$migration->insertData()) {
						Logger::log(
							"Unable to insert test data in migration \"{$migrationName}\" from db \"" .
							Db::PREFIX .
							$site["db_name"] .
							"\"",
							Logger::LEVEL_ERROR,
							"console.migrate"
						);
						return false;
					}
				}
			}
		} catch (Exception $e) {
			return false;
		}

		if ($this->_isReset && App::console()->isDebug) {
			$connection = Db::setConnect(
				App::console()->db["db_host"],
				App::console()->db["db_user"],
				App::console()->db["db_password"],
				App::console()->db["db_name"],
				App::console()->db["charset"]
			);
			if (!$connection) {
				return false;
			}

			if (!mysql_query("TRUNCATE TABLE migrations")) {
				Logger::log("Unable to truncate table \"migrations\"", Logger::LEVEL_ERROR, "console.migrate");
				return false;
			}
		}

		return true;
	}

	/**
	 * Обновление версий
	 *
	 * @return bool
	 */
	private function _updateVersions()
	{
		$connection = Db::setConnect(
			App::console()->db["host"],
			App::console()->db["user"],
			App::console()->db["password"],
			App::console()->db["base"],
			App::console()->db["charset"]
		);
		if (!$connection) {
			return false;
		}

		Db::startTransaction();
		foreach ($this->_migrations as $migration) {
			if (!mysql_query("INSERT INTO migrations (version) VALUES('" . $migration . "')")) {
				Db::rollbackTransaction();

				Logger::log("Unable to update versions", Logger::LEVEL_INFO, "console.migrate");
				return false;
			}
		}

		Db::commitTransaction();
		return true;
	}
}