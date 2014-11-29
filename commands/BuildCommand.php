<?php

namespace commands;

use system\App;
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

		$this->_gitCheckout(App::console()->releaseBranch);

		$migrateCommand = new MigrateCommand;
		if (!$migrateCommand->run()) {
			$this->_gitCheckout(App::console()->prevReleaseBranch);

			Logger::log("Build failure", Logger::LEVEL_INFO, "console.build");
			return false;
		}

		Logger::log("Build successfully completed", Logger::LEVEL_INFO, "console.build");
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

	/**
	 * Производит сборку ветки
	 *
	 * @param string $branch название ветки
	 *
	 * @return bool
	 */
	private function _gitCheckout($branch) {
		$command = "
			git add .;
			git reset --hard;
			git fetch --all -p;
			git checkout {$branch};
			git rebase origin/{$branch};
			chmod 777 c;
		";
		exec($command);

		return true;
	}
}