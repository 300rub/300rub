<?php

namespace commands;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use system\App;
use system\base\Logger;
use system\console\Command;

/**
 * Runs tests
 *
 * @package commands
 */
class TestCommand extends Command
{

	/**
	 * Ending of class names (ExampleTest)
	 */
	const COMMAND_ENDING = "Test";

	/**
	 * Collection of test's classes
	 *
	 * @var array
	 */
	private $_classes = [];

	/**
	 * Map of classes and methods
	 *
	 * @var array
	 */
	private $_map = [];

	/**
	 * Test's count
	 *
	 * @var int
	 */
	private $_count = 0;

	/**
	 * Count of successful tests
	 *
	 * @var int
	 */
	private $_success = 0;

	/**
	 * Count of error tests
	 *
	 * @var int
	 */
	private $_errors = 0;

	/**
	 * Name of current test
	 *
	 * @var string
	 */
	public static $activeTest = "";

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 *
	 * @return bool
	 */
	public function run($args)
	{
		Logger::log("Start to run tests", Logger::LEVEL_INFO, "console.tests");

		$this->_setClasses()->_setMap();

		if (!$this->_setMigrations()) {
			Logger::log("Unable to apply migrations before tests", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		Logger::log("Count of all tests: {$this->_count}", Logger::LEVEL_INFO, "console.tests");

		if (!$this->_applyFixtures()) {
			Logger::log("Unable to load test's data", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		if (!$this->_applyTests()) {
			Logger::log("Unable to apply tests", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		if ($this->_count != $this->_success) {
			Logger::log(
				"There are some errors. Count: {$this->_errors}",
				Logger::LEVEL_ERROR,
				"console.tests"
			);
			return false;
		}

		if (!$this->_setMigrations(true)) {
			Logger::log("Unable to apply migrations after tests", Logger::LEVEL_ERROR, "console.tests");
			return false;
		}

		Logger::log("All tests successfully executed", Logger::LEVEL_INFO, "console.tests");
		return true;
	}

	/**
	 * Sets classes for testing
	 *
	 * @return TestCommand
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

		return $this;
	}

	/**
	 * Sets map of classes and methods
	 *
	 * @return TestCommand
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

		return $this;
	}

	/**
	 * Applies migrations
	 *
	 * @param bool $isTestData is necessary to insert test data
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
	 * Applies fixtures
	 *
	 * @return bool
	 */
	private function _applyFixtures()
	{
		$dir = App::console()->config->rootDir . "/tests/fixtures";

		$handle = opendir($dir);
		if (!$handle) {
			Logger::log("Unable to open folder with fixtures", Logger::LEVEL_ERROR, "console.migrate");
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
						Logger::log("Unable to save data for {$class}", Logger::LEVEL_ERROR, "console.migrate");
						var_dump($model->errors);
						return false;
					}
				}
			}
		}

		return true;
	}

	/**
	 * Applies tests
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