<?php

namespace testS\commands;

use testS\applications\App;
use testS\models\AbstractModel;

/**
 * Load fixtures command
 *
 * @package testS\commands
 */
class LoadFixturesCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		self::load();
	}

	/**
	 * Clear DB script
	 */
	public static function load()
	{
		$siteId = App::getApplication()->config->siteId;

		// Files
		$uploadFilesFolder = __DIR__ . "/../public/upload/{$siteId}";
		exec("rm -r {$uploadFilesFolder}");
		$copyFilesFolder = __DIR__ . "/../fixtures/files";
		if (!file_exists(__DIR__ . "/../public/upload")) {
			mkdir(__DIR__ . "/../public/upload", 0777);
		}
		exec("cp -r {$copyFilesFolder} {$uploadFilesFolder}");
		chmod($uploadFilesFolder, 0777);

		// DB
		$files = array_diff(scandir(__DIR__ . "/../fixtures"), ["..", ".", "files"]);

		foreach ($files as $file) {
			$records = require(__DIR__ . "/../fixtures/" . $file);

			foreach ($records as $id => $record) {
				$modelName = "\\testS\\models\\" . ucfirst(str_replace(".php", "", $file)) . "Model";

				/**
				 * @var AbstractModel $model
				 */
				$model = new $modelName;
				$model->checkParentBeforeSave = false;
				$model->setAttributes($record);
				$model->save();
			}
		}
	}
}