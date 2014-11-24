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
}