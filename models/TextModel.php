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
		return array();
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			"rows"   => array(),
			"editor" => array(),
			"tag"    => array(),
			"text"  => array(),
		);
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