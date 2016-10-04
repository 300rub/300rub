<?php

namespace testS\commands;

use components\exceptions\FileException;
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

/**
 * Class for working with compress static
 *
 * @package commands
 */
class CompressStaticCommand extends AbstractCommand
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
		$publicVendorCommand = new PublicVendorCommand();
		$publicVendorCommand->run($args);

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
					throw new FileException("Unable to create CSS file: {file} with lessc", ["file" => $output]);
				}

				$map[$type]["css"][] = $cssFileName;
			}
		}

		// Compressing
		foreach ($map as $type => $files) {
			$objectCss = new CSS();
			$objectJs = new JS();
			$outputCssFile = "{$cssFolder}/{$type}.min.css";
			$outputJsFile = "{$cssFolder}/{$type}.min.js";

			foreach ($files["css"] as $file) {
				$filePath = "{$cssFolder}/{$file}";
				if (!file_exists($filePath)) {
					throw new FileException("Unable to open CSS file: {file}", ["file" => $filePath]);
				}

				$objectCss->add($filePath);
			}

			foreach ($files["js"] as $file) {
				$filePath = "{$jsFolder}/{$file}";
				if (!file_exists($filePath)) {
					throw new FileException("Unable to open JS file: {file}", ["file" => $filePath]);
				}

				$objectJs->add($filePath);
			}

			$objectCss->minify($outputCssFile);
			if (!file_exists($outputCssFile)) {
				throw new FileException("Unable to create CSS output file: {file}", ["file" => $outputCssFile]);
			}

			$objectJs->minify($outputJsFile);
			if (!file_exists($outputJsFile)) {
				throw new FileException("Unable to create JS output file: {file}", ["file" => $outputJsFile]);
			}
		}
	}
}