<?php

namespace tests\unit\models;

use system\console\Test;
use models\SectionModel;

/**
 * Тест для модели SectionModel
 *
 * @package tests.unit.models
 */
class SectionModelTest extends Test
{

	/**
	 * Тест на количество всех записей
	 *
	 * @return bool
	 */
	public function testCountAll()
	{
		return $this->assertEquals(3, count(SectionModel::model()->findAll()));
	}

	/**
	 * Поиск по URL
	 *
	 * @return bool
	 */
	public function testFindByUrl()
	{
		$model = SectionModel::model()->byUrl("url-1")->find();
		if (!$model) {
			return false;
		}

		return $this->assertEquals(1, (int)$model->id);
	}

	/**
	 * Валидация пустых значений
	 *
	 * @return bool
	 */
	public function testRequired()
	{
		return $this->checkValidate(
			new SectionModel,
			array(
				"t.language"    => array("required"),
				"seoModel.name" => array("required"),
				"seoModel.url"  => array("required"),
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
		$attributes = array(
			"t.language"    => 1,
			"seoModel.name" => "Название",
			"seoModel.url"  => "некорректный url",
		);

		$model = new SectionModel;
		$model->setAttributes($attributes);

		return $this->checkValidate(
			$model,
			array(
				"seoModel.url" => array("url")
			),
			false
		);
	}

	/**
	 * Сохранение новой модели с минимальным набором параметров
	 *
	 * @return bool
	 */
	public function testInsertMin()
	{
		$model = new SectionModel;
		$model->seo_id = 1;
		$model->language = 1;

		return $this->checkSave(
			$model,
			array(
				"t.seo_id"             => 1,
				"t.language"           => 1,
				"t.width"              => SectionModel::DEFAULT_WIDTH,
				"t.is_main"            => 0,
				"seoModel.name"        => "Название 1",
				"seoModel.url"         => "url-1",
				"seoModel.title"       => "Заголовок 1",
				"seoModel.keywords"    => "Ключевые слова 1",
				"seoModel.description" => "Описание 1",
			)
		);
	}

	/**
	 * Сохранение новой модели с СЕО
	 *
	 * @return bool
	 */
	public function testInsertWithSeo()
	{
		$attributes = array(
			"t.language"           => 1,
			"seoModel.name"        => "Название",
			"seoModel.title"       => "Заголовок",
			"seoModel.keywords"    => "Ключевые слова",
			"seoModel.description" => "Описание",
		);

		$model = new SectionModel;
		$model->setAttributes($attributes);

		return $this->checkSave(
			$model,
			array(
				"t.seo_id"             => 6,
				"t.language"           => 1,
				"t.width"              => SectionModel::DEFAULT_WIDTH,
				"t.is_main"            => 0,
				"seoModel.name"        => "Название",
				"seoModel.url"         => "nazvanie",
				"seoModel.title"       => "Заголовок",
				"seoModel.keywords"    => "Ключевые слова",
				"seoModel.description" => "Описание",
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
		$attributes = array(
			"t.is_main"            => 0,
			"t.width"              => 1200,
			"seoModel.name"        => "Новое название",
			"seoModel.title"       => "Новый заголовок",
			"seoModel.keywords"    => "Новые ключевые слова",
			"seoModel.description" => "Новое описание",
		);

		$model = SectionModel::model()->byId(1)->with(array("seoModel"))->find();
		$model->setAttributes($attributes);

		return $this->checkSave(
			$model,
			array(
				"t.is_main"            => 0,
				"t.width"              => 1200,
				"seoModel.name"        => "Новое название",
				"seoModel.url"         => "url-1",
				"seoModel.title"       => "Новый заголовок",
				"seoModel.keywords"    => "Новые ключевые слова",
				"seoModel.description" => "Новое описание",
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
		return $this->checkDelete(SectionModel::model()->byId(1)->withAll()->find());
	}
}