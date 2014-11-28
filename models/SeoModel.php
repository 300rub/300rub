<?php

namespace models;

use system\base\Model;

/**
 * Файл класса SeoModel
 *
 * @package models
 */
class SeoModel extends Model
{

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "seo";
	}

	public function rules()
	{
		return array(
			"name"        => array(),
			"url"         => array(),
			"title"       => array(),
			"keywords"    => array(),
			"description" => array(),
		);
	}

	/**
	 * Получает объект модели
	 *
	 * @param string $className
	 *
	 * @return SectionModel
	 */
	public static function model($className = __CLASS__)
	{
		return new $className;
	}

	public function relations()
	{
		return array();
	}
}