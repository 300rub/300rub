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
}