<?php

namespace system\base;

/**
 * Файл класса Language
 *
 * @package system.base
 */
class Language
{

	/**
	 * Идентификатор языка
	 *
	 * @var int
	 */
	public static $id = 1;

	/**
	 * Абривиатура языка
	 *
	 * @var string
	 */
	public static $name = "ru";

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
	public static $languageList = array(
		self::LANGUAGE_RU => "ru",
	);

	/**
	 * Устанавливает идентификатор языка
	 *
	 * @param string $name абривиатура языка
	 *
	 * @return void
	 */
	public static function setIdByName($name)
	{
		$id = array_search($name, self::$languageList);
		if ($id) {
			self::$id = $id;
		}
	}

	/**
	 * Переводит фразу
	 *
	 * @param string $category категория
	 * @param string $message  сообщение
	 *
	 * @return string
	 */
	public static function t($category, $message)
	{
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
		$converter = array(
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
		);

		return strtr($string, $converter);
	}
}