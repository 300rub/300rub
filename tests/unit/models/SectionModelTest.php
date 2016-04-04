<?php

namespace tests\unit\models;

use models\SectionModel;

/**
 * Tests for model SectionModel
 *
 * @package tests\unit\models
 */
class SectionModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return SectionModel
	 */
	protected function getModel()
	{
		return new SectionModel;
	}

	/**
	 * Data provider for CRUD test
	 *
	 * @return array
	 */
	public function dataProviderForCRUD()
	{
		return [];
	}

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
		$this->assertEquals(1, SectionModel::model()->byUrl("texts")->find()->id);
	}
}