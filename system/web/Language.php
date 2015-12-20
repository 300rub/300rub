<?php

namespace system\web;

use system\base\Exception;

/**
 * Class contains lib of static functions for working with language
 *
 * @package system.web
 */
class Language
{

	/**
	 * Active language ID
	 *
	 * @var int
	 */
	public static $activeId = 0;

	/**
	 * Language ID. Russian
	 *
	 * @var int
	 */
	const LANGUAGE_RU = 1;

	/**
	 * List of languages
	 *
	 * @var array
	 */
	public static $aliasList = [
		self::LANGUAGE_RU => "ru",
	];

	/**
	 * Sets ID by alias
	 *
	 * @param string $name Language alias
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public static function setIdByAlias($name)
	{
		$id = array_search($name, self::$aliasList);
		if ($id) {
			self::$activeId = $id;
		} else {
			throw new Exception(Language::t("common", "Такого языка не существует ({$name})"));
		}
	}

	/**
	 * Gets active alias
	 *
	 * @return string
	 */
	public static function getActiveAlias()
	{
		if (in_array(self::$activeId, self::$aliasList)) {
			return self::$aliasList[self::$activeId];
		}

		return self::$aliasList[self::LANGUAGE_RU];
	}

	/**
	 * Translates message
	 *
	 * @param string $category    Category
	 * @param string $message     Message
	 * @param array  $replacement Replacement
	 *
	 * @return string
	 */
	public static function t($category, $message, $replacement = [])
	{
		foreach ($replacement as $key => $value) {
			$message = str_replace("{" . $key . "}", $value, $message);
		}

		return $message;
	}

	/**
	 * Transliteration
	 *
	 * @param string $string String for transliteration
	 *
	 * @return string
	 */
	public static function translit($string)
	{
		$converter = [
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'д' => 'd',
			'е' => 'e',
			'ё' => 'e',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'i',
			'й' => 'y',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'h',
			'ц' => 'c',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'sch',
			'ь' => '',
			'ы' => 'y',
			'ъ' => '',
			'э' => 'e',
			'ю' => 'yu',
			'я' => 'ya',
			'А' => 'a',
			'Б' => 'b',
			'В' => 'v',
			'Г' => 'g',
			'Д' => 'd',
			'Е' => 'e',
			'Ё' => 'e',
			'Ж' => 'zh',
			'З' => 'z',
			'И' => 'i',
			'Й' => 'y',
			'К' => 'k',
			'Л' => 'l',
			'М' => 'm',
			'Н' => 'n',
			'О' => 'o',
			'П' => 'p',
			'Р' => 'r',
			'С' => 's',
			'Т' => 't',
			'У' => 'u',
			'Ф' => 'f',
			'Х' => 'h',
			'Ц' => 'c',
			'Ч' => 'ch',
			'Ш' => 'sh',
			'Щ' => 'sch',
			'Ь' => '',
			'Ы' => 'y',
			'Ъ' => '',
			'Э' => 'e',
			'Ю' => 'yu',
			'Я' => 'ya',
		];

		return strtr($string, $converter);
	}
}