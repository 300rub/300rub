<?php

namespace models;

use system\App;
use system\base\Model;

/**
 * Файл класса TextModel
 *
 * @package models
 */
class TextModel extends Model
{

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "texts";
	}

	public function relations()
	{
		return [];
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"rows"   => [],
			"editor" => [],
			"tag"    => [],
			"text"  => [],
		];
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return TextModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}
}