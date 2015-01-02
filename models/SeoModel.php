<?php

namespace models;

use system\base\Language;
use system\base\Model;

/**
 * Файл класса SeoModel
 *
 * @package models
 */
class SeoModel extends Model
{

	/**
	 * Название
	 *
	 * @var string
	 */
	public $name = "";

	/**
	 * Абривиатура URL
	 *
	 * @var string
	 */
	public $url = "";

	/**
	 * Заголовок страницы
	 *
	 * @var string
	 */
	public $title = "";

	/**
	 * Ключевые слова
	 *
	 * @var string
	 */
	public $keywords = "";

	/**
	 * Описание
	 *
	 * @var string
	 */
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

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			"name"        => array("required", "max" => 255),
			"url"         => array("required", "url", "max" => 255),
			"title"       => array("max" => 100),
			"keywords"    => array("max" => 255),
			"description" => array("max" => 255),
		);
	}

	/**
	 * Связи
	 *
	 * @return array
	 */
	public function relations()
	{
		return array();
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

	/**
	 * Выполняется перед валидацией модели
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->name = strip_tags($this->name);
		$this->url = strip_tags($this->url);
		$this->title = strip_tags($this->title);
		$this->keywords = strip_tags($this->keywords);
		$this->description = strip_tags($this->description);

		if ($this->name && !$this->url) {
			$this->url = $this->name;
		}
		$this->url = Language::translit($this->url);
		$this->url = str_replace("_", "-", $this->url);
		$this->url = str_replace(" ", "-", $this->url);
		$this->url = strtolower($this->url);
		$this->url = preg_replace('~[^-a-z0-9]+~u', '', $this->url);
		$this->url = trim($this->url, "-");
	}

	/**
	 * Поиск по url
	 *
	 * @param string $url url
	 *
	 * @return SeoModel
	 */
	public function byUrl($url)
	{
		if (!$url) {
			return $this;
		}

		$this->db->addCondition("t.url = :url");
		$this->db->params["url"] = $url;

		return $this;
	}
}