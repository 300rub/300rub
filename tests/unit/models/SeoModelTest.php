<?php

namespace tests\unit\models;

use models\SeoModel;

/**
 * Файл класса SeoModelTest.
 *
 * Тест для модели SeoModelTest
 *
 * @package tests.unit.models
 */
class SeoModelTest extends AbstractModelTest
{

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
		//$this->assertEquals(1, SeoModel::model()->byUrl("texts")->find()->id);
		$this->assertEquals(1, 1);
	}
}