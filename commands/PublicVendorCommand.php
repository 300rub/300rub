<?php

namespace testS\commands;

use testS\components\exceptions\FileException;

/**
 * Static public class
 *
 * @package testS\commands
 */
class PublicVendorCommand extends AbstractCommand
{

    /**
     * CSS map
     *
     * @var array
     */
    private static $_cssMap = [
        "gridstack.min.css"                      => "troolee/gridstack/dist/gridstack.min.css",
        "colorpicker/jquery.colorpicker.css"     => "vanderlee/colorpicker/jquery.colorpicker.css",
        "colorpicker/images/bar.png"             => "vanderlee/colorpicker/images/bar.png",
        "colorpicker/images/bar-alpha.png"       => "vanderlee/colorpicker/images/bar-alpha.png",
        "colorpicker/images/bar-opacity.png"     => "vanderlee/colorpicker/images/bar-opacity.png",
        "colorpicker/images/bar-pointer.png"     => "vanderlee/colorpicker/images/bar-pointer.png",
        "colorpicker/images/map.png"             => "vanderlee/colorpicker/images/map.png",
        "colorpicker/images/map-opacity.png"     => "vanderlee/colorpicker/images/map-opacity.png",
        "colorpicker/images/map-pointer.png"     => "vanderlee/colorpicker/images/map-pointer.png",
        "colorpicker/images/preview-opacity.png" => "vanderlee/colorpicker/images/preview-opacity.png",
        "colorpicker/images/ui-colorpicker.png"  => "vanderlee/colorpicker/images/ui-colorpicker.png",
        "fa/css/font-awesome.min.css"            => "FortAwesome/Font-Awesome/css/font-awesome.min.css",
        "fa/css/font-awesome.css.map"            => "FortAwesome/Font-Awesome/css/font-awesome.css.map",
        "fa/fonts/FontAwesome.otf"               => "FortAwesome/Font-Awesome/fonts/FontAwesome.otf",
        "fa/fonts/fontawesome-webfont.eot"       => "FortAwesome/Font-Awesome/fonts/fontawesome-webfont.eot",
        "fa/fonts/fontawesome-webfont.svg"       => "FortAwesome/Font-Awesome/fonts/fontawesome-webfont.svg",
        "fa/fonts/fontawesome-webfont.ttf"       => "FortAwesome/Font-Awesome/fonts/fontawesome-webfont.ttf",
        "fa/fonts/fontawesome-webfont.woff"      => "FortAwesome/Font-Awesome/fonts/fontawesome-webfont.woff",
        "fa/fonts/fontawesome-webfont.woff2"     => "FortAwesome/Font-Awesome/fonts/fontawesome-webfont.woff2",
        "hover-min.css"                          => "IanLunn/Hover/css/hover-min.css",
    ];

    /**
     * JS map
     *
     * @var array
     */
    private static $_jsMap = [
        "jquery.min.js"                              => "components/jquery/jquery.min.js",
        "jquery-ui.min.js"                           => "components/jqueryui/jquery-ui.min.js",
        "lodash.min.js"                              => "lodash/lodash/dist/lodash.min.js",
        "gridstack.min.js"                           => "troolee/gridstack/dist/gridstack.min.js",
        "gridstack.min.map"                          => "troolee/gridstack/dist/gridstack.min.map",
        "jquery.colorpicker.js"                      => "vanderlee/colorpicker/jquery.colorpicker.js",
        "tinymce/tinymce.jquery.min.js"              => "tinymce/tinymce/tinymce.jquery.min.js",
        "tinymce/themes/modern/theme.min.js"         => "tinymce/tinymce/themes/modern/theme.min.js",
        "tinymce/skins/lightgray/skin.min.css"       => "tinymce/tinymce/skins/lightgray/skin.min.css",
        "tinymce/skins/lightgray/content.min.css"    => "tinymce/tinymce/skins/lightgray/content.min.css",
        "tinymce/skins/lightgray/fonts/tinymce.woff" => "tinymce/tinymce/skins/lightgray/fonts/tinymce.woff",
        "tinymce/skins/lightgray/fonts/tinymce.ttf"  => "tinymce/tinymce/skins/lightgray/fonts/tinymce.ttf",
        "tinymce/plugins/textcolor/plugin.min.js"    => "tinymce/tinymce/plugins/textcolor/plugin.min.js",
        "tinymce/plugins/link/plugin.min.js"         => "tinymce/tinymce/plugins/link/plugin.min.js",
        "tinymce/plugins/hr/plugin.min.js"           => "tinymce/tinymce/plugins/hr/plugin.min.js",
        "tinymce/plugins/image/plugin.min.js"        => "tinymce/tinymce/plugins/image/plugin.min.js",
        "tinymce/plugins/charmap/plugin.min.js"      => "tinymce/tinymce/plugins/charmap/plugin.min.js",
        "tinymce/plugins/print/plugin.min.js"        => "tinymce/tinymce/plugins/print/plugin.min.js",
        "tinymce/plugins/preview/plugin.min.js"      => "tinymce/tinymce/plugins/preview/plugin.min.js",
        "tinymce/plugins/fullscreen/plugin.min.js"   => "tinymce/tinymce/plugins/fullscreen/plugin.min.js",
        "tinymce/plugins/table/plugin.min.js"        => "tinymce/tinymce/plugins/table/plugin.min.js",
        "less.min.js"                                => "less/less/dist/less.min.js",
        "md5.min.js"                                 => "blueimp/JavaScript-MD5/js/md5.min.js",
    ];

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
        $map = [
            "css" => self::$_cssMap,
            "js"  => self::$_jsMap,
        ];

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