<?php

namespace models;

use system\web\Language;

/**
 * Model for working with table "seo"
 *
 * @package models
 */
class SeoModel extends AbstractModel
{

	/**
	 * Name
	 *
	 * @var string
	 */
	public $name = "";

	/**
	 * URL alias
	 *
	 * @var string
	 */
	public $url = "";

	/**
	 * SEO title
	 *
	 * @var string
	 */
	public $title = "";

	/**
	 * SEO keywords
	 *
	 * @var string
	 */
	public $keywords = "";

	/**
	 * SEO description
	 *
	 * @var string
	 */
	public $description = "";

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return "seo";
	}

	/**
	 * Validation rules
	 *
	 * @return array
	 */
	public function getRules()
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
	 * Gets model object
	 *
	 * @return SeoModel
	 */
	public static function model()
	{
		$className = __CLASS__;
		return new $className;
	}

	/**
	 * Runs before validation
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
	 * Adds url condition to SQL
	 *
	 * @param string $url URL
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

	/**
	 * Duplicates SEO
	 *
	 * @param bool $useTransaction Is transaction used
	 *
	 * @return int
	 */
	public function duplicate($useTransaction = true)
	{
		$seoModel = clone $this;
		$seoModel->id = null;
		$seoModel->name = Language::t("common", "copy") . " {$seoModel->name}";
		$seoModel->url .= "-copy" . rand(1000, 100000);
		$seoModel->title = "";
		$seoModel->keywords = "";
		$seoModel->description = "";

		$seoModel->save($useTransaction);

		return intval($seoModel->id);
	}
}