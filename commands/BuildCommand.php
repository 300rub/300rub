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

	const RELEASE_PREFIX = "release/";

	/**
	 * Применяемая ветка
	 *
	 * @var string
	 */
	private $_branch = "master";

	/**
	 * Ветка для отката
	 *
	 * @var string
	 */
	private $_prevBranch = "master";

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args)
	{
		Logger::log("Build has been started", Logger::LEVEL_INFO, "console.build");

		if (!$this->_checkFolders()) {
			exit();
		}

		$this->_setBranches($args);

		$this->_gitCheckout($this->_branch);

		$migrateCommand = new MigrateCommand;
		if (!$migrateCommand->run($args)) {
			$this->_gitCheckout($this->_prevBranch);

			Logger::log("Build failure", Logger::LEVEL_INFO, "console.build");
			return false;
		}

		Logger::log("Build successfully completed", Logger::LEVEL_INFO, "console.build");
		return true;
	}

	/**
	 * Устанавливает ветки
	 *
	 * @param string[] $args аргументы
	 *
	 * @return void
	 */
	private function _setBranches($args)
	{
		foreach ($args as $arg) {
			if ($arg != MigrateCommand::ARG_RESET && $arg != MigrateCommand::ARG_DATA) {
				$this->_branch = $arg;
			}
		}

		if (!App::console()->isDebug) {
			$this->_branch = self::RELEASE_PREFIX . App::console()->release;
		}
		if (!App::console()->isDebug) {
			$this->_prevBranch = self::RELEASE_PREFIX . App::console()->prevRelease;
		}
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