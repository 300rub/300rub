<?php

namespace ss\commands\files;

use ss\commands\_abstract\AbstractCommand;
use ss\application\exceptions\FileException;

/**
 * Static public class
 */
class PublicVendorCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @throws FileException
	 */
	public function run()
	{
        $map = include CODE_ROOT . "/config/other/staticVendor.php";

		foreach ($map as $folder => $types) {
			foreach ($types as $type) {
				foreach ($type as $staticFIle => $vendorFile) {
					$this->_process($folder, $staticFIle, $vendorFile);
				}
			}
		}
	}

	/**
	 * Processes
	 *
	 * @param string $folder     Folder
	 * @param string $staticFIle Static file
	 * @param string $vendorFile Vendor file
	 *
	 * @throws FileException
	 *
	 * @return void
	 */
	private function _process($folder, $staticFIle, $vendorFile)
	{
		$dir = sprintf('%s/public/static/%s/lib', CODE_ROOT, $folder);
		if (file_exists($dir) === false
			&& mkdir($dir, 0777) === false
		) {
			throw new FileException(
				"Unable to create the folder: {folder}",
				[
					"folder" => $dir
				]
			);
		}

		$explode = explode("/", $staticFIle);
		$newDir = $dir;
		$count = count($explode);
		if ($count > 1) {
			for ($i = 0; $i < $count - 1; $i++) {
				$newDir .= "/" . $explode[$i];
				if (file_exists($newDir) === false
					&& mkdir($newDir, 0777) === false
				) {
					throw new FileException(
						"Unable to create the folder: {folder}",
						[
							"folder" => $newDir
						]
					);
				}
			}
			$staticFIle = $explode[$count - 1];
			$dir = $newDir;
		}

		$file = sprintf('%s/%s', $dir, $staticFIle);
		if (file_exists($file) === false) {
			$vendorFile = sprintf('%s/vendor/%s', CODE_ROOT, $vendorFile);
			if (file_exists($vendorFile) === false) {
				throw new FileException(
					"File: {file} not found",
					[
						"file" => $vendorFile
					]
				);

			}

			copy($vendorFile, $file);
		}
	}
}
