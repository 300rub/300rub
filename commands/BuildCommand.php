<?php

namespace commands;

use system\App;
use system\base\Exception;
use system\console\Command;
use system\base\Logger;

/**
 * Файл класса BuildCommand
 *
 * Производит сборку
 *
 * @package commands
 */
class BuildCommand extends Command
{

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args)
	{
		if (!$this->_checkFolders()) {
			exit();
		}

		$migrateCommand = new MigrateCommand;
		if (!$migrateCommand->run()) {
			return false;
		}

		return true;
	}

	/**
	 * Проверяет папки для хранения на существование
	 *
	 * @return bool
	 */
	private function _checkFolders()
	{
		$logs = App::console()->rootDir . DIRECTORY_SEPARATOR . "logs";
		if (!file_exists($logs) && !mkdir($logs, 0777)) {
			echo "	> Unable to create folder \"logs\"\n";
			return false;
		}

		$backups = App::console()->rootDir . DIRECTORY_SEPARATOR . "backups";
		if (!file_exists($backups) && !mkdir($backups, 0777)) {
			Logger::log("Unable to create folder \"backups\"", Logger::LEVEL_ERROR, "console.build");
			return false;
		}

		$vendors = App::console()->rootDir . DIRECTORY_SEPARATOR . "vendors";
		if (!file_exists($vendors) && !mkdir($vendors, 0777)) {
			Logger::log("Unable to create folder \"vendors\"", Logger::LEVEL_ERROR, "console.build");
			return false;
		}

		return true;
	}

	private function _gitCheckout($branch) {
		$command = "
			git add .;
			git fetch --all -p;
			git reset --hard origin/{$branch};
		";
	}
}