<?php

namespace testS\components;

/**
 * Class for working with views
 *
 * @package testS\components
 */
class View
{

	/**
	 * Gets content from view
	 *
	 * @param string $viewFile View file
	 * @param array  $data     Data
	 *
	 * @return string
	 */
	public static function get($viewFile, $data = [])
	{
		$path = self::_getViewsRootDir() . $viewFile . ".php";

		extract($data, EXTR_OVERWRITE);

		ob_start();
		ob_implicit_flush(false);
		require($path);
		return ob_get_clean();
	}

	/**
	 * Gets path to views root dir
	 *
	 * @return string
	 */
	private static function _getViewsRootDir()
	{
		return __DIR__ . "/../views/";
	}
}