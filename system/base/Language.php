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
	public static $activeId = 1;

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
	private static $_aliasList = array(
		self::LANGUAGE_RU => "ru",
	);

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
		$id = array_search($name, self::$_aliasList);
		if ($id) {
			self::$activeId = $id;
		} else {
			throw new Exception(Language::t("common", "Такого языка не существует"));
		}
	}

	/**
	 * Получает активную абривиатуру url
	 *
	 * @return string
	 */
	public static function getActiveAlias()
	{
		if (in_array(self::$activeId, self::$_aliasList)) {
			return self::$_aliasList[self::$activeId];
		}

		return self::$_aliasList[self::LANGUAGE_RU];
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