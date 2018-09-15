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
     * CSS map
     *
     * @var array
     */
    private $_cssMap = [
        "gridstack.min.css"
			=> "troolee/gridstack/dist/gridstack.min.css",
        "colorpicker/jquery.colorpicker.css"
			=> "vanderlee/colorpicker/jquery.colorpicker.css",
        "colorpicker/images/bar.png"
			=> "vanderlee/colorpicker/images/bar.png",
        "colorpicker/images/bar-alpha.png"
			=> "vanderlee/colorpicker/images/bar-alpha.png",
        "colorpicker/images/bar-opacity.png"
			=> "vanderlee/colorpicker/images/bar-opacity.png",
        "colorpicker/images/bar-pointer.png"
			=> "vanderlee/colorpicker/images/bar-pointer.png",
        "colorpicker/images/map.png"
			=> "vanderlee/colorpicker/images/map.png",
        "colorpicker/images/map-opacity.png"
			=> "vanderlee/colorpicker/images/map-opacity.png",
        "colorpicker/images/map-pointer.png"
			=> "vanderlee/colorpicker/images/map-pointer.png",
        "colorpicker/images/preview-opacity.png"
			=> "vanderlee/colorpicker/images/preview-opacity.png",
        "colorpicker/images/ui-colorpicker.png"
			=> "vanderlee/colorpicker/images/ui-colorpicker.png",
        "fa/css/fontawesome-all.min.css"
			=> "fortawesome/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css",
        "fa/webfonts/fa-brands-400.eot"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-brands-400.eot",
		"fa/webfonts/fa-brands-400.svg"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-brands-400.svg",
		"fa/webfonts/fa-brands-400.ttf"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-brands-400.ttf",
		"fa/webfonts/fa-brands-400.woff"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-brands-400.woff",
		"fa/webfonts/fa-brands-400.woff2"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-brands-400.woff2",
		"fa/webfonts/fa-regular-400.eot"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-regular-400.eot",
		"fa/webfonts/fa-regular-400.svg"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-regular-400.svg",
		"fa/webfonts/fa-regular-400.ttf"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-regular-400.ttf",
		"fa/webfonts/fa-regular-400.woff"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-regular-400.woff",
		"fa/webfonts/fa-regular-400.woff2"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-regular-400.woff2",
		"fa/webfonts/fa-solid-900.eot"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-solid-900.eot",
		"fa/webfonts/fa-solid-900.svg"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-solid-900.svg",
		"fa/webfonts/fa-solid-900.ttf"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-solid-900.ttf",
		"fa/webfonts/fa-solid-900.woff"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-solid-900.woff",
		"fa/webfonts/fa-solid-900.woff2"
			=> "fortawesome/font-awesome/web-fonts-with-css/webfonts/fa-solid-900.woff2",
        "hover-min.css"
			=> "IanLunn/Hover/css/hover-min.css",
		"jquery.fancybox.min.css"
			=> "fancyapps/fancybox/dist/jquery.fancybox.min.css",
		"cropper.min.css"
			=> "fengyuanchen/cropper/dist/cropper.min.css",
	];

    /**
     * JS map
     *
     * @var array
     */
    private $_jsMap = [
        "jquery.min.js"
			=> "components/jquery/jquery.min.js",
        "jquery-ui.min.js"
			=> "components/jqueryui/jquery-ui.min.js",
		"underscore-min.js"
			=> "components/underscore/underscore-min.js",
        "gridstack.min.js"
			=> "troolee/gridstack/dist/gridstack.min.js",
        "gridstack.min.map"
			=> "troolee/gridstack/dist/gridstack.min.map",
        "jquery.colorpicker.js"
			=> "vanderlee/colorpicker/jquery.colorpicker.js",
        "tinymce/tinymce.min.js"
			=> "tinymce/tinymce/tinymce.min.js",
		"tinymce/jquery.tinymce.min.js"
			=> "tinymce/tinymce/jquery.tinymce.min.js",
        "tinymce/themes/modern/theme.min.js"
			=> "tinymce/tinymce/themes/modern/theme.min.js",
        "tinymce/skins/lightgray/skin.min.css"
			=> "tinymce/tinymce/skins/lightgray/skin.min.css",
        "tinymce/skins/lightgray/content.min.css"
			=> "tinymce/tinymce/skins/lightgray/content.min.css",
        "tinymce/skins/lightgray/fonts/tinymce.woff"
			=> "tinymce/tinymce/skins/lightgray/fonts/tinymce.woff",
        "tinymce/skins/lightgray/fonts/tinymce.ttf"
			=> "tinymce/tinymce/skins/lightgray/fonts/tinymce.ttf",
        "tinymce/plugins/textcolor/plugin.min.js"
			=> "tinymce/tinymce/plugins/textcolor/plugin.min.js",
        "tinymce/plugins/link/plugin.min.js"
			=> "tinymce/tinymce/plugins/link/plugin.min.js",
        "tinymce/plugins/hr/plugin.min.js"
			=> "tinymce/tinymce/plugins/hr/plugin.min.js",
        "tinymce/plugins/image/plugin.min.js"
			=> "tinymce/tinymce/plugins/image/plugin.min.js",
		"tinymce/plugins/imagetools/plugin.min.js"
			=> "tinymce/tinymce/plugins/imagetools/plugin.min.js",
        "tinymce/plugins/charmap/plugin.min.js"
			=> "tinymce/tinymce/plugins/charmap/plugin.min.js",
        "tinymce/plugins/print/plugin.min.js"
			=> "tinymce/tinymce/plugins/print/plugin.min.js",
        "tinymce/plugins/preview/plugin.min.js"
			=> "tinymce/tinymce/plugins/preview/plugin.min.js",
        "tinymce/plugins/fullscreen/plugin.min.js"
			=> "tinymce/tinymce/plugins/fullscreen/plugin.min.js",
        "tinymce/plugins/table/plugin.min.js"
			=> "tinymce/tinymce/plugins/table/plugin.min.js",
		"jquery.fancybox.min.js"
			=> "fancyapps/fancybox/dist/jquery.fancybox.min.js",
		"jssor.slider.min.js"
			=> "jssor/slider/js/jssor.slider.min.js",
		"cropper.min.js"
			=> "fengyuanchen/cropper/dist/cropper.min.js",
	];

	/**
	 * Runs the command
	 *
	 * @throws FileException
	 */
	public function run()
	{
        $map = [
            "css" => $this->_cssMap,
            "js"  => $this->_jsMap,
        ];

		foreach ($map as $folder => $list) {
			foreach ($list as $key => $value) {
				$this->_process($folder, $key, $value);
			}
		}
	}

	/**
	 * Processes
	 *
	 * @param string $folder Folder
	 * @param string $key    Key
	 * @param string $value  Value
	 *
	 * @throws FileException
	 *
	 * @return void
	 */
	private function _process($folder, $key, $value)
	{
		$vendorsDir = CODE_ROOT . "/vendor";
		$staticDir = CODE_ROOT . "/public";

		$dir = sprintf('%s/%s/lib', $staticDir, $folder);
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

		$explode = explode("/", $key);
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
			$key = $explode[$count - 1];
			$dir = $newDir;
		}

		$file = sprintf('%s/%s', $dir, $key);
		if (file_exists($file) === false) {
			$vendorFile = sprintf('%s/%s', $vendorsDir, $value);
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
