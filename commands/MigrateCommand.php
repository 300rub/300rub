<?php

namespace commands;

use system\console\Command;
use system\db\Db;

class MigrateCommand extends Command
{

	private $_migrations = array();

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args)
	{
		$this->_getNewMigrationList();

		return true;
	}

	private function _getNewMigrationList()
	{
		$list = array();

		$dir = self::$config["rootDir"] . DIRECTORY_SEPARATOR . "migrations";

		$handle = opendir($dir);
		if (!$handle) {
			$this->log("Migrations folder does not open!");
			return $list;
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$list[] = str_replace(".php", "", $file);
			}
		}

		if (!$list) {
			$this->log("Migrations not found!");
			return $list;
		}

		Db::setConnect(
			self::$config["db"]["host"],
			self::$config["db"]["user"],
			self::$config["db"]["password"],
			self::$config["db"]["base"],
			self::$config["db"]["charset"]
		);
	}
}