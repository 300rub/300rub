<?php

namespace models;

use system\base\Language;
use system\base\Model;
use system\db\Db;

/**
 * Файл класса SectionModel
 *
 * @package models
 *
 * @method SectionModel byId
 * @method SectionModel find
 */
class SectionModel extends Model
{

	/**
	 * Стандартная ширина
	 */
	const DEFAULT_WIDTH = 980;

	/**
	 * Идннтификатор раздела
	 *
	 * @var int
	 */
	public $seo_id = 0;

	/**
	 * Идентификатор языка
	 *
	 * @var int
	 */
	public $language = 0;

	/**
	 * Ширина
	 *
	 * @var int
	 */
	public $width = 0;

	/**
	 * Является ли раздел главным
	 *
	 * @var bool
	 */
	public $is_main = false;

	/**
	 * @var SeoModel
	 */
	public $seoModel = null;

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	public function tableName()
	{
		return "sections";
	}

	/**
	 * Правила валидации
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			"seo_id"   => array(),
			"language" => array("required"),
			"width"    => array(),
			"is_main"  => array(),
		);
	}

	/**
	 * Возвращает связи между объектами
	 *
	 * @return array
	 */
	public function relations()
	{
		return array(
			"seoModel" => array('models\SeoModel', "seo_id")
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

	/**
	 * Поиск по url
	 *
	 * @param string $url url раздела
	 *
	 * @return SectionModel
	 */
	public function byUrl($url = "")
	{
		$this->db->with[] = "seoModel";
		$this->db->addCondition("t.language = :language");
		$this->db->params["language"] = Language::$id;

		if ($url) {
			$this->db->addCondition("seoModel.url = :url");
			$this->db->params["url"] = $url;
		} else {
			$this->db->addCondition("t.is_main = 1");
		}

		return $this;
	}

	/**
	 * Выполняется перед валидацией модели
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
		$this->seo_id = intval($this->seo_id);
		$this->language = intval($this->language);
		$this->width = intval($this->width);
		$this->is_main = intval($this->is_main);

		if (!$this->width) {
			$this->width = self::DEFAULT_WIDTH;
		}
	}

	/**
	 * Выполняется перед сохранением модели
	 *
	 * @return bool
	 */
	protected function beforeSave()
	{
		if ($this->is_main) {
			Db::execute("UPDATE " . $this->tableName() . " SET is_main = 0");
		}

		return parent::beforeSave();
	}
}