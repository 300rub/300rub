<?php

namespace commands;

use system\App;
use system\base\Logger;
use system\console\Command;

/**
 * Файл класса PublicStaticCommand
 *
 * Публикует статику
 *
 * @package commands
 */
class PublicStaticCommand extends Command
{

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args = array())
	{
		$vendorsDir = App::console()->config->rootDir . DIRECTORY_SEPARATOR . "vendors";
		$staticDir = App::console()->config->rootDir . DIRECTORY_SEPARATOR . "public";
		$map = require(App::console()->config->rootDir . "/config/static_map.php");

		foreach ($map as $folder => $list) {
			foreach ($list as $key => $value) {
				$dir = "{$staticDir}/{$folder}/lib";
				if (!file_exists($dir) && !mkdir($dir, 0777)) {
					Logger::log("Невозможно создать папку {$dir}", Logger::LEVEL_ERROR, "console.publicStatic");
					return false;
				}
				if (!file_exists("{$dir}/{$key}")) {
					$file = "{$vendorsDir}/{$value}";
					if (file_exists($file)) {
						copy($file, "{$dir}/{$key}");
					} else {
						Logger::log(
							"Не найден файл {$vendorsDir}/{$value}",
							Logger::LEVEL_ERROR,
							"console.publicStatic"
						);
						return false;
					}
				}
			}
		}

		Logger::log("Статика успешно опубликована", Logger::LEVEL_INFO, "console.publicStatic");
		return true;
	}
}