<?php

namespace tests\unit\models;

use system\console\Test;
use models\SeoModel;

/**
 * Файл класса SeoModelTest.
 *
 * Тест для модели SeoModelTest
 *
 * @package tests.unit.models
 */
class SeoModelTest extends Test
{

	/**
	 * Тест на количество всех записей
	 *
	 * @return bool
	 */
	public function testCountAll()
	{
		return $this->assertEquals(3, count(SeoModel::model()->findAll()));
	}

	/**
	 * Валидация пустых сначений
	 *
	 * @return bool
	 */
	public function testRequired()
	{
		return $this->checkValidate(
			new SeoModel,
			array(
				"name" => array("required"),
				"url"  => array("required")
			)
		);
	}

	/**
	 * Валидация длинных строк
	 *
	 * @return bool
	 */
	public function testMax()
	{
		$model = new SeoModel;
		$model->name = "Длинное название, очень длинное название, очень длинное название, очень длинное название,
			очень длинное название, очень длинное название, очень длинное название, очень длинное название,
			очень длинное название, очень длинное название, очень длинное название, очень длинное название";
		//$model->url сгенерируется автоматически в $model->beforeValidate()
		$model->title = "Длинный заголовок, очень длинный заголовок, очень длинный заголовок, очень длинный заголовок";
		$model->keywords = "Длинные ключевые слова, очень длинные ключевые слова, очень длинные ключевые слова,
			очень длинные ключевые слова, очень длинные ключевые слова, очень длинные ключевые слова, очень длинные
			, очень длинные ключевые слова, очень длинные ключевые слова";
		$model->description = "Длинное описание, очень длинное описание, очень длинное описание, очень длинное
			описание, очень длинное описание, очень длинное описание, очень длинное описание, очень длинное описание,
			очень длинное описание, очень длинное описание, очень длинное описание";

		return $this->checkValidate(
			$model,
			array(
				"name"        => array("max"),
				"url"         => array("max"),
				"title"       => array("max"),
				"keywords"    => array("max"),
				"description" => array("max"),
			)
		);
	}

	/**
	 * Валидация некорректрого url
	 *
	 * @return bool
	 */
	public function testUrl()
	{
		$model = new SeoModel;
		$model->name = "Название";
		$model->url = "некорректный url";

		return $this->checkValidate(
			$model,
			array(
				"url" => array("url")
			),
			false
		);
	}
}