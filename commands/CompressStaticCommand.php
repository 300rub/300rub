<?php

namespace commands;

use system\base\Logger;
use system\console\Command;
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

/**
 * Class for working with compress static
 *
 * @package commands
 */
class CompressStaticCommand extends Command
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
		$publicVendorCommand = new PublicVendorCommand();
		if (!$publicVendorCommand->run($args)) {
			Logger::log("Unable to public vendor static", Logger::LEVEL_ERROR, "console.compressStatic");
			return false;
		}

		$cssFolder = __DIR__ . "/../public/css";
		$outputCommon = "{$cssFolder}/common.css";
		$outputAdmin = "{$cssFolder}/admin.css";
		mkdir($cssFolder, 0777);
		exec("lessc {$cssFolder}/less.less {$outputCommon}");
		exec("lessc {$cssFolder}/admin.less {$outputAdmin}");
		if (!file_exists($outputCommon) || !file_exists($outputAdmin)) {
			Logger::log("Unable to create CSS files with lessc", Logger::LEVEL_ERROR, "console.compressStatic");
			return false;
		}

		$map = require(__DIR__ . "/../config/static_map.php");

		foreach ($map["css"] as $output => $files) {
			$objectCss = new CSS();
			$cssFolder = __DIR__ . "/../public/css";
			$outputFile = "{$cssFolder}/{$output}";
			foreach ($files as $file) {
				$filePath = "{$cssFolder}/{$file}";
				if (!file_exists($filePath)) {
					Logger::log(
						"Unable to open CSS file \"{$filePath}\"",
						Logger::LEVEL_ERROR,
						"console.compressStatic"
					);
					return false;
				}

				$objectCss->add($filePath);
			}

			$objectCss->minify($outputFile);
			if (!file_exists($outputFile)) {
				Logger::log(
					"Unable to create CSS output file \"{$outputFile}\"",
					Logger::LEVEL_ERROR,
					"console.compressStatic"
				);
				return false;
			}
		}

		foreach ($map["js"] as $output => $files) {
			$objectJs = new JS();
			$jsFolder = __DIR__ . "/../public/js";
			$outputFile = "{$jsFolder}/{$output}";
			foreach ($files as $file) {
				$filePath = "{$jsFolder}/{$file}";
				if (!file_exists($filePath)) {
					Logger::log(
						"Unable to open JS file \"{$filePath}\"",
						Logger::LEVEL_ERROR,
						"console.compressStatic"
					);
					return false;
				}

				$objectJs->add($filePath);
			}

			$objectJs->minify($outputFile);
			if (!file_exists($outputFile)) {
				Logger::log(
					"Unable to create JS output file \"{$outputFile}\"",
					Logger::LEVEL_ERROR,
					"console.compressStatic"
				);
				return false;
			}
		}

		Logger::log("Static files were successfully compressed", Logger::LEVEL_INFO, "console.compressStatic");
		return true;
	}
}