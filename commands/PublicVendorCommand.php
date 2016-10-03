<?php

namespace commands;

use components\exceptions\FileException;

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
	 * @throws FileException
	 */
	public function run($args = [])
	{
		$vendorsDir = __DIR__ . "/../vendor";
		$staticDir = __DIR__ . "/../public";
		$map = require(__DIR__ . "/../config/vendor_map.php");

		foreach ($map as $folder => $list) {
			foreach ($list as $key => $value) {
				$dir = "{$staticDir}/{$folder}/lib";
				if (!file_exists($dir) && !mkdir($dir, 0777)) {
					throw new FileException("Unable to create the folder: {folder}", ["folder" => $dir]);
				}

				$explode = explode("/", $key);
				$newDir = $dir;
				if (count($explode) > 1) {
					for ($i = 0; $i < count($explode) - 1; $i++) {
						$newDir .= "/" . $explode[$i];
						if (!file_exists($newDir) && !mkdir($newDir, 0777)) {
							throw new FileException("Unable to create the folder: {folder}", ["folder" => $newDir]);
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
						throw new FileException("File: {file} not found", ["file" => "{$vendorsDir}/{$value}"]);
					}
				}
			}
		}
	}
}