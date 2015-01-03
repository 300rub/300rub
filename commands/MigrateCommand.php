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
	 * Вставка тестовой информации
	 * Доступна только в режиме отладки
	 *
	 * @var bool
	 */
	public $isTestData = true;

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
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args = array())
	{
		if (!$this->_checkCommonTables()) {
			Logger::log("Не найдены базовые таблицы", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		Logger::log("Началось применение миграций", Logger::LEVEL_INFO, "console.build");

		if (App::console()->config->isDebug) {
			Logger::log("Предусмотрена очистка баз перед выполнением", Logger::LEVEL_INFO, "console.migrate");
			if ($this->isTestData) {
				Logger::log("Предусмотрена вставка тестовой информации", Logger::LEVEL_INFO, "console.migrate");
			}
		}

		if (!$this->_setNewMigrations()) {
			Logger::log("Не удалось определить миграции на выполнение", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_setSites()) {
			Logger::log("Не удалось определить сайты", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_createDumps()) {
			Logger::log("Не удалось создать дампы для бэкапа", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		if (!$this->_applyMigration() || !$this->_updateVersions()) {
			Logger::log("Не удалось применить миграции", Logger::LEVEL_ERROR, "console.migrate");

			if ($this->_rollbackDumps()) {
				Logger::log("Все базы данных были успешно откатаны", Logger::LEVEL_INFO, "console.migrate");
			} else {
				Logger::log("Произошла ошибка при откате баз!!!", Logger::LEVEL_ERROR, "console.migrate");
			}

			return false;
		}

		Logger::log("Все миграции успешно применены", Logger::LEVEL_INFO, "console.migrate");
		return true;
	}

	/**
	 * Проверяет наличие основных таблиц
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
					"Не удалось создать таблицу \"migrations\" в базе " . App::console()->config->db->name,
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
					"Не удалось создать таблицу \"sites\" в базе " . App::console()->config->db->name,
					Logger::LEVEL_ERROR,
					"console.migrate"
				);
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
		$rows = Db::fetchAll("SELECT * FROM `migrations`");
		foreach ($rows as $row) {
			$versions[] = $row["version"];
		}

		$handle = opendir(App::console()->config->rootDir . DIRECTORY_SEPARATOR . "migrations");
		if (!$handle) {
			Logger::log("Не удалось открыть папку с миграциями", Logger::LEVEL_ERROR, "console.migrate");
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
	 * Устанавливает сайты
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
	 * Делает дампы баз данных
	 *
	 * @return bool
	 */
	private function _createDumps()
	{
		foreach ($this->_sites as $site) {
			if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
				Logger::log(
					"Не удалось подключиться к базе \"" . $site["db_name"] . "\"",
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
				App::console()->config->rootDir .
				"/backups/" .
				$site["db_name"] .
				".sql.gz"
			);
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
			$file = App::console()->config->rootDir . "/backups/" . $site["db_name"] . ".sql.gz";
			if (!file_exists($file)) {
				Logger::log(
					"Не удалось найти файл для базы \"" . $site["db_name"] . "\"",
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
	 * Применяет миграции
	 *
	 * @return bool
	 */
	private function _applyMigration()
	{
		if (!$this->_migrations) {
			Logger::log("Нет не примененных миграций", Logger::LEVEL_INFO, "console.migrate");
			return true;
		}

		if (!$this->_sites) {
			Logger::log("Сайты не найдены", Logger::LEVEL_INFO, "console.migrate");
			return true;
		}

		sort($this->_migrations);

		try {
			foreach ($this->_sites as $site) {
				if (!Db::setPdo($site["db_user"], $site["db_password"], $site["db_name"])) {
					Logger::log(
						"Не удалось соединиться с базой \"" . $site["db_name"] . "\"",
						Logger::LEVEL_ERROR,
						"console.migrate"
					);
					return false;
				}

				if (App::console()->config->isDebug) {
					$tables = array();

					$rows = Db::fetchAll("SHOW TABLES FROM " . $site["db_name"]);
					foreach ($rows as $row) {
						foreach ($row as $key => $value)
						$tables[] = $value;
					}

					foreach($tables as $table){
						if (
							$table !== "migrations"
							&& $table !== "sites"
							&& !Db::execute("DROP TABLE `{$table}`")
						) {
							Logger::log(
								"Не удалось удалить таблицу {$table} из базы " . $site["db_name"],
								Logger::LEVEL_ERROR,
								"console.migrate"
							);
							return false;
						}
					}

					Logger::log(
						"База \"" . $site["db_name"] . "\" успешна очищена",
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
							"Не удалось применить миграцию \"{$migrationName}\" для базы \"" . $site["db_name"] . "\"",
							Logger::LEVEL_ERROR,
							"console.migrate"
						);
						return false;
					}
					Logger::log(
						"Миграция \"{$migrationName}\" успешно выполнена",
						Logger::LEVEL_INFO,
						"console.migrate"
					);

					if (App::console()->config->isDebug && $this->isTestData) {
						if (!$migration->insertData()) {
							Logger::log(
								"Не удалось вставить тестовую информацию в миграции \"{$migrationName}\" для базы \"" .
								$site["db_name"] .
								"\"",
								Logger::LEVEL_ERROR,
								"console.migrate"
							);
							return false;
						}
						Logger::log(
							"Тестовая информация для миграции \"{$migrationName}\" успешно вставлена",
							Logger::LEVEL_INFO,
							"console.migrate"
						);
					}
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
				Logger::log("Не удалось очистить таблицу \"migrations\"", Logger::LEVEL_ERROR, "console.migrate");
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
		if (
			!Db::setPdo(
				App::console()->config->db->user,
				App::console()->config->db->password,
				App::console()->config->db->name
			)
		) {
			Logger::log("Не удалось подключиться к основной базе", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		Db::startTransaction();
		foreach ($this->_migrations as $migration) {
			if (!Db::execute("INSERT INTO `migrations` (version) VALUES(?)", array($migration))) {
				Db::rollbackTransaction();

				Logger::log("Не удалось обновить версии миграций", Logger::LEVEL_ERROR, "console.migrate");
				return false;
			}
		}

		Db::commitTransaction();
		return true;
	}
}