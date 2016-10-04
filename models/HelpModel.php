<?php

namespace testS\models;

/**
 * Model for working with table "help"
 *
 * @package models
 * 
 * @method HelpModel find
 */
class HelpModel extends AbstractModel
{

	/**
	 * Language
	 *
	 * @var string
	 */
	public $language = "";

	/**
	 * Category
	 *
	 * @var string
	 */
	public $category = "";

	/**
	 * Name
	 *
	 * @var string
	 */
	public $name = "";

	/**
	 * Content
	 *
	 * @var string
	 */
	public $content = "";

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "help";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			"content" => []
		];
	}

	/**
	 * Gets model object
	 *
	 * @return HelpModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Adds condition to SQL
	 *
	 * @param string $language Language
	 * @param string $category Category
	 * @param string $name     Name
	 *
	 * @return HelpModel
	 */
	public function setParams($language, $category, $name)
	{
		$this->db->addCondition("t.language = :language");
		$this->db->params["language"] = $language;

		$this->db->addCondition("t.category = :category");
		$this->db->params["category"] = $category;

		$this->db->addCondition("t.name = :name");
		$this->db->params["name"] = $name;

		return $this;
	}

	/**
	 * Sets values
	 */
	protected function setValues()
	{
	}
}