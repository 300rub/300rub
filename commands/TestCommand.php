<?php

namespace commands;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use system\App;
use system\base\Logger;
use system\console\Command;

/**
 * Файл класса TestCommand
 *
 * Команда для выполнения тестов
 *
 * @package commands
 */
class TestCommand extends Command
{

	/**
	 * Окончание в название команды
	 */
	const COMMAND_ENDING = "Test";

	/**
	 * Названия классов для теста
	 *
	 * @var array
	 */
	private $_classes = [];

	/**
	 * Карта кассов и методов
	 *
	 * @var array
	 */
	private $_map = [];

	/**
	 * Количество исполняемых тестов
	 *
	 * @var int
	 */
	private $_count = 0;

	/**
	 * Количество успешных тестов
	 *
	 * @var int
	 */
	private $_success = 0;

	/**
	 * Количество тестов с ошибками
	 *
	 * @var int
	 */
	private $_errors = 0;

	/**
	 * Название активного теста
	 *
	 * @var string
	 */
	public static $activeTest = "";

	/**
	 * Выполняет команду
	 *
	 * @param string[] $args аргументы
	 *
	 * @return bool
	 */
	public function run($args)
	{
		Logger::log("Началось выполнение тестов", Logger::LEVEL_INFO, "console.tests");

		if (!$this->_setClasses()) {
			Logger::log("Не удалось установить классы для теста", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		if (!$this->_setMap()) {
			Logger::log("Не удалось установить карту кассов и методов", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		if (!$this->_setMigrations()) {
			Logger::log("Не применить миграции до тестов", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		Logger::log("Всего тестов: {$this->_count}", Logger::LEVEL_INFO, "console.tests");

		if (!$this->_applyFixtures()) {
			Logger::log("Не удалось загрузить данные для тестов", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		if (!$this->_applyTests()) {
			Logger::log("Не удалось применить тесты", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		if ($this->_count != $this->_success) {
			Logger::log(
				"Возникли ошибки во время выполнения тестов. Всего: {$this->_errors}",
				Logger::LEVEL_ERROR,
				"console.tests"
			);
			return false;
		}

		if (!$this->_setMigrations(true)) {
			Logger::log("Не удалось применить миграции после тестов", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		Logger::log("Выполнение тестов успешно завершено", Logger::LEVEL_INFO, "console.tests");
		return true;
	}

	/**
	 * Устанавливает названия классов для теста
	 *
	 * @return bool
	 */
	private function _setClasses()
	{
		$dir = App::console()->config->rootDir . "/tests/unit";
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {

			$file = str_replace($dir . "/", "", $file->getPathname());

			if (strripos($file, self::COMMAND_ENDING . ".php")) {
				$this->_classes[] = "\\tests\\unit\\" . str_replace(".php", "", str_replace("/", "\\", $file));
			}
		}

		return true;
	}

	/**
	 * Устанавливает карту кассов и методов
	 *
	 * @return bool
	 */
	private function _setMap()
	{
		foreach ($this->_classes as $class) {
			$testMethods = [];
			$classMethods = get_class_methods($class);
			foreach ($classMethods as $classMethod) {
				if (strpos($classMethod, "test") !== false) {
					$testMethods[] = $classMethod;
					$this->_count++;
				}
			}
			$this->_map[$class] = $testMethods;
		}

		return true;
	}

	/**
	 * Применяет миграции
	 *
	 * @param bool $isTestData вставлять ли тестовую информацию
	 *
	 * @return bool
	 */
	private function _setMigrations($isTestData = false)
	{
		$migrateCommand = new MigrateCommand;
		$migrateCommand->isTestData = $isTestData;

		return $migrateCommand->run();
	}

	/**
	 * Загружает данные
	 *
	 * @return bool
	 */
	private function _applyFixtures()
	{
		$dir = App::console()->config->rootDir . "/tests/fixtures";

		$handle = opendir($dir);
		if (!$handle) {
			Logger::log("Не удалось открыть папку с данными", Logger::LEVEL_ERROR, "console.migrate");
			return false;
		}

		/**
		 * @var \SplFileInfo       $file
		 * @var \system\base\Model $model
		 */
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
			if (strpos($file->getFilename(), ".php")) {
				$fixtures = require($file->getPathname());
				$class = "\\models\\" . ucfirst(str_replace(".php", "", $file->getFilename())) . "Model";
				foreach ($fixtures as $fixture) {
					$model = new $class;
					foreach ($fixture as $key => $value) {
						$model->$key = $value;
					}
					$model->id = null;
					if (!$model->save()) {
						Logger::log("Не удалось сохранить данные для {$class}", Logger::LEVEL_ERROR, "console.migrate");
						var_dump($model->errors);
						return false;
					}
				}
			}
		}

		return true;
	}

	/**
	 * Применяет тесты
	 *
	 * @return bool
	 */
	private function _applyTests()
	{
		foreach ($this->_map as $className => $tests) {
			$class = new $className;
			foreach ($tests as $test) {
				self::$activeTest = $test;
				if ($class->$test() === false) {
					$this->_errors++;
				} else {
					$this->_success++;
				}
			}
		}

		return true;
	}
}