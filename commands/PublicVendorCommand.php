<?php

namespace commands;

use components\Logger;

/**
 * Static public class
 *
 * @package commands
 */
class PublicVendorCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 *
	 * @return bool
	 */
	public function run($args = [])
	{
		$vendorsDir = __DIR__ . "/../vendors";
		$staticDir = __DIR__ . "/../public";
		$map = require(__DIR__ . "/../config/vendor_map.php");

		foreach ($map as $folder => $list) {
			foreach ($list as $key => $value) {
				$dir = "{$staticDir}/{$folder}/lib";
				if (!file_exists($dir) && !mkdir($dir, 0777)) {
					Logger::log("НUnable to create folder {$dir}", Logger::LEVEL_ERROR, "console.publicStatic");
					return false;
				}

				$explode = explode("/", $key);
				$newDir = $dir;
				if (count($explode) > 1) {
					for ($i = 0; $i < count($explode) - 1; $i++) {
						$newDir .= "/" . $explode[$i];
						if (!file_exists($newDir) && !mkdir($newDir, 0777)) {
							Logger::log(
								"Unable to create folder {$newDir}",
								Logger::LEVEL_ERROR,
								"console.publicStatic"
							);
							return false;
						}
					}
					$key = $explode[count($explode) - 1];
					$dir = $newDir;
				}

				if (!file_exists("{$dir}/{$key}")) {
					$file = "{$vendorsDir}/{$value}";
					if (file_exists($file)) {
						copy($file, "{$dir}/{$key}");
					} else {
						Logger::log(
							"File {$vendorsDir}/{$value} not found",
							Logger::LEVEL_ERROR,
							"console.publicStatic"
						);
						return false;
					}
				}
			}
		}

		Logger::log("Static files were successfully published", Logger::LEVEL_INFO, "console.publicStatic");
		return true;
	}
}