<?php

namespace system\web;

use system\base\Exception;

/**
 * Файл класса Language
 *
 * @package system.web
 */
class Language
{

	/**
	 * Идентификатор языка
	 *
	 * @var int
	 */
	public static $activeId = 0;

	/**
	 * Идентификатор русского языка
	 *
	 * @var int
	 */
	const LANGUAGE_RU = 1;

	/**
	 * Список языков
	 *
	 * @var array
	 */
	public static $aliasList = [
		self::LANGUAGE_RU => "ru",
	];

	/**
	 * Устанавливает идентификатор языка
	 *
	 * @param string $name абривиатура языка
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
	 * Получает активную абривиатуру url
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
	 * Переводит фразу
	 *
	 * @param string $category    категория
	 * @param string $message     сообщение
	 * @param array  $replacement замены
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
	 * Транслитерация
	 *
	 * @param string $string входящая строка
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