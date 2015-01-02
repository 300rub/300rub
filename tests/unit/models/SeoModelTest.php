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
	 * Поиск по URL
	 *
	 * @return bool
	 */
	public function testFindByUrl()
	{
		$model = SeoModel::model()->byUrl("url-2")->find();
		if (!$model) {
			return false;
		}

		return $this->assertEquals(2, (int)$model->id);
	}

	/**
	 * Валидация пустых значений
	 *
	 * @return bool
	 */
	public function testRequired()
	{
		return $this->checkValidate(
			new SeoModel,
			array(
				"t.name" => array("required"),
				"t.url"  => array("required")
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
				"t.name"        => array("max"),
				"t.url"         => array("max"),
				"t.title"       => array("max"),
				"t.keywords"    => array("max"),
				"t.description" => array("max"),
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
				"t.url" => array("url")
			),
			false
		);
	}

	/**
	 * Сохранение новой модели
	 *
	 * @return bool
	 */
	public function testInsert()
	{
		$attributes = array(
			"t.name"        => "Название 1",
			"t.url"         => "nazvanie-1",
			"t.title"       => "Заголовок 1",
			"t.keywords"    => "Ключевые слова 1",
			"t.description" => "Описание 1",
		);

		$model = new SeoModel;
		$model->setAttributes($attributes);

		return $this->checkSave($model, $attributes);
	}

	/**
	 * Сохранение новой модели с тегами
	 *
	 * @return bool
	 */
	public function testInsertWithTags()
	{
		$model = new SeoModel;
		$model->name = "<b>Название 2<?php echo 123; ?></b>";
		$model->url = "<strong>na</strong>zvanie-2";
		$model->title = "Заголовок <<script>>2</script>";
		$model->keywords = "<b>Ключевые слова 2</b>";
		$model->description = "<b>Описание 2</strong>";

		return $this->checkSave(
			$model,
			array(
				"t.name"        => "Название 2",
				"t.url"         => "nazvanie-2",
				"t.title"       => "Заголовок 2",
				"t.keywords"    => "Ключевые слова 2",
				"t.description" => "Описание 2",
			)
		);
	}

	/**
	 * Обновление модели
	 *
	 * @return bool
	 */
	public function testUpdate()
	{
		$model = SeoModel::model()->byId(1)->find();
		$model->name = "Новое название";
		$model->url = "Новый URL";
		$model->title = "Новый заголовок";
		$model->keywords = "Новые ключевые слова";
		$model->description = "Новое описание";

		return $this->checkSave(
			$model,
			array(
				"t.name"        => "Новое название",
				"t.url"         => "novyy-url",
				"t.title"       => "Новый заголовок",
				"t.keywords"    => "Новые ключевые слова",
				"t.description" => "Новое описание",
			)
		);
	}

	/**
	 * Обновление модели с пустым URL
	 *
	 * @return bool
	 */
	public function testUpdateWithEmptyUrl()
	{
		$model = SeoModel::model()->byId(1)->find();
		$model->name = "Новое название";
		$model->url = "";

		return $this->checkSave(
			$model,
			array(
				"t.name" => "Новое название",
				"t.url"  => "novoe-nazvanie",
			)
		);
	}

	/**
	 * Обновление модели с неизменным URL
	 *
	 * @return bool
	 */
	public function testUpdateUnchangeableUrl()
	{
		$model = SeoModel::model()->byId(1)->find();
		$model->name = "Новое название";

		return $this->checkSave(
			$model,
			array(
				"t.name" => "Новое название",
				"t.url"  => "url-1",
			)
		);
	}

	/**
	 * Удаление модели
	 *
	 * @return bool
	 */
	public function testDelete()
	{
		return $this->checkDelete(SeoModel::model()->byId(1)->find());
	}
}