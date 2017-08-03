<?php

namespace testS\components;
use testS\components\exceptions\CommonException;
use testS\models\AbstractModel;
use testS\models\DesignBlockModel;
use testS\models\DesignTextModel;

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

	/**
	 * Generates CSS
	 *
	 * @param AbstractModel $model
	 * @param string        $selector
	 *
	 * @throws CommonException
	 *
	 * @return array
	 */
	public static function generateCss(AbstractModel $model, $selector)
	{
		$type = null;
		if ($model instanceof DesignBlockModel) {
			$type = "block";
		} elseif ($model instanceof DesignTextModel) {
			$type = "text";
		}

		if ($type === null) {
			throw new CommonException(
				"Unable to detect design type to get CSS. Model given: {class}",
				[
					"class" => get_class($model)
				]
			);
		}

		$id = sprintf(
			"%s-%s",
			str_replace([".", " "], ["", "-"], $selector),
			$type
		);

		$css = View::get(
			"design/" . $type,
			[
				"model"    => $model,
				"id"       => $id,
				"selector" => $selector,
			]
		);

		return [
			$id => $css
		];
	}
}