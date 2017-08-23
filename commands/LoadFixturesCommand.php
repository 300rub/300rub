<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\models\AbstractModel;

/**
 * Load fixtures command
 *
 * @package testS\commands
 */
class LoadFixturesCommand extends AbstractCommand
{

    /**
     * Order of fixtures loading
     *
     * @var string[]
     */
    private static $fixtureOrder = [
        "settings",
        "user",
        "userSession",
        "text",
        "textInstance",
        "block",
        "section",
        "gridLine",
        "grid",
		"userSettingsOperation",
		"userBlockGroupOperation",
		"tab",
		"tabGroup",
		"tabTemplate",
		"field",
		"fieldTemplate",
		"fieldGroup",
		"catalog",
		"catalogMenu",
		"image",
		"imageGroup",
		"search",
		"menu",
		"menuInstance",
		"record",
		"catalogInstance",
		"catalogBin",
    ];

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
		// Files
//		$siteId = App::getInstance()->getConfig()->siteId;
//		$uploadFilesFolder = __DIR__ . "/../public/upload/{$siteId}";
//		exec("rm -r {$uploadFilesFolder}");
//		$copyFilesFolder = __DIR__ . "/../fixtures/files";
//		if (!file_exists(__DIR__ . "/../public/upload")) {
//			mkdir(__DIR__ . "/../public/upload", 0777);
//		}
//		exec("cp -r {$copyFilesFolder} {$uploadFilesFolder}");
//		chmod($uploadFilesFolder, 0777);

        Db::setLocalhostPdo();

		// DB
		foreach (self::$fixtureOrder as $fixture) {
		    $filePath = __DIR__ . "/../fixtures/{$fixture}.php";

			$records = require($filePath);
			foreach ($records as $id => $record) {
				$modelName = "\\testS\\models\\" . ucfirst($fixture) . "Model";

				/**
				 * @var AbstractModel $model
				 */
				$model = new $modelName;
				$model->set($record);
				$model->save();
			}
		}
	}
}