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

		$map = require(__DIR__ . "/../config/static_map.php");
		$cssFolder = __DIR__ . "/../public/css";
		$jsFolder = __DIR__ . "/../public/css";
		mkdir($cssFolder, 0777);
		mkdir($jsFolder, 0777);

		// LESS to CSS
		foreach ($map as $type => $files) {
			foreach ($files["less"] as $file) {
				$cssFileName = str_replace(".less", ".css", $file);
				$output = "{$cssFolder}/{$cssFileName}";
				exec("lessc {$cssFolder}/$file {$output}");

				if (!file_exists($output)) {
					Logger::log(
						"Unable to create CSS file \"{$output}\" with lessc",
						Logger::LEVEL_ERROR,
						"console.compressStatic");
					return false;
				}

				$map[$type]["css"][] = $cssFileName;
			}
		}

		// Compressing
		foreach ($map as $type => $files) {
			$objectCss = new CSS();
			$objectJs = new CSS();
			$outputCssFile = "{$cssFolder}/{$type}.min.css";
			$outputJsFile = "{$cssFolder}/{$type}.min.js";

			foreach ($files["css"] as $file) {
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

			foreach ($files["js"] as $file) {
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

			$objectCss->minify($outputCssFile);
			if (!file_exists($outputCssFile)) {
				Logger::log(
					"Unable to create CSS output file \"{$outputCssFile}\"",
					Logger::LEVEL_ERROR,
					"console.compressStatic"
				);
				return false;
			}

			$objectJs->minify($outputJsFile);
			if (!file_exists($outputJsFile)) {
				Logger::log(
					"Unable to create JS output file \"{$outputJsFile}\"",
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