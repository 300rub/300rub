<?php

namespace tests\unit\models;

use models\SectionModel;

/**
 * Тест для модели SectionModel
 *
 * @package tests.unit.models
 */
class SectionModelTest extends AbstractModelTest
{

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
		$this->assertEquals(1, SectionModel::model()->byUrl("texts")->find()->id);
	}
}