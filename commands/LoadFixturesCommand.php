<?php

namespace testS\commands;

use testS\components\Db;
use testS\components\Language;
use testS\models\AbstractModel;

/**
 * Load fixtures command
 *
 * @package testS\commands
 */
class LoadFixturesCommand extends AbstractCommand
{

	/**
	 * File Data
	 *
	 * @var array
	 */
	private static $_fileData = [];

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
		"image",
		"imageGroup",
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
        Db::setLocalhostPdo();

		$dir = "";
		switch (APP_ENV) {
			case ENV_TEST:
				$dir = "test";
				break;
			case ENV_DEV:
				$dir = "dev";
				break;
		}

		// DB
		foreach (self::$fixtureOrder as $fixture) {
		    $filePath = __DIR__ . "/../fixtures/{$dir}/{$fixture}.php";

			if (!file_exists($filePath)) {
				continue;
			}

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

		// Files
		$map = require(__DIR__ . "/../fixtures/{$dir}/_fileMap.php");
		foreach ($map as $data) {
			if (array_key_exists("mimeType", $data)) {
				$mimeType = $data["mimeType"];
			} else {
				$mimeType = "application/octet-stream";
			}
			if (array_key_exists("language", $data)) {
				$language = $data["language"];
			} else {
				$language = Language::LANGUAGE_EN_ID;
			}

			self::sendFile(
				$data["controller"],
				$data["action"],
				$data["file"],
				$data["data"],
				$mimeType,
				$language
			);
		}
	}

	/**
	 * Sends a file
	 *
	 * @param string $controller
	 * @param string $action
	 * @param string $fileName
	 * @param array  $data
	 * @param string $mimeType
	 * @param int    $language
	 */
	private static function sendFile(
		$controller,
		$action,
		$fileName,
		array $data = [],
		$mimeType = "application/octet-stream",
		$language = Language::LANGUAGE_EN_ID
	) {
		$host = trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'"));

		self::$_fileData = [];
		self::_setFileData($data);
		$postData = array(
			"token"      => "c4ca4238a0b923820dcc509a6f75849b",
			"controller" => $controller,
			"action"     => $action,
			"language"   => $language,
			'file'       => curl_file_create(__DIR__ . '/../fixtures/files/' . $fileName, $mimeType)
		);
		$postData = array_merge($postData, self::$_fileData);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $host . "/api/");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

		curl_exec($curl);
	}

	/**
	 * Sets file data
	 *
	 * @param array  $data
	 * @param string $prefix
	 */
	private static function _setFileData(array $data, $prefix = "data")
	{
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				self::_setFileData($value, sprintf("%s[%s]", $prefix, $key));
			} else {
				self::$_fileData[sprintf("%s[%s]", $prefix, $key)] = $value;
			}
		}
	}
}