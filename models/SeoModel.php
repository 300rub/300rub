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

	public $name = "";
	public $url = "";
	public $title = "";
	public $keywords = "";
	public $description = "";

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
			"name"        => array("required", "max" => 255),
			"url"         => array("required", "max" => 255),
			"title"       => array("max" => 100),
			"keywords"    => array("max" => 255),
			"description" => array("max" => 255),
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