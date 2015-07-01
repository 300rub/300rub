<?php

namespace models;

use system\web\Language;
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
	 * Типы форм для полей
	 *
	 * @var array
	 */
	public $formTypes = [
		"name"        => "field",
		"url"         => "field",
		"title"       => "field",
		"keywords"    => "field",
		"description" => "field",
	];

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
		return [
			"name"        => ["required", "max" => 255],
			"url"         => ["required", "url", "max" => 255],
			"title"       => ["max" => 100],
			"keywords"    => ["max" => 255],
			"description" => ["max" => 255],
		];
	}

	/**
	 * Названия полей
	 *
	 * @return array
	 */
	public function labels()
	{
		return [
			"name"        => Language::t("common", "Название"),
			"url"         => Language::t("common", "Абривиатура URL"),
			"title"       => Language::t("common", "Тег title"),
			"keywords"    => Language::t("common", "Тег keywords"),
			"description" => Language::t("common", "Тег description"),
		];
	}

	/**
	 * Связи
	 *
	 * @return array
	 */
	public function relations()
	{
		return [];
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