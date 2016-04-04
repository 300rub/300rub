<?php

namespace tests\unit\models;

use models\SeoModel;

/**
 * Tests for model SeoModelTest.
 *
 * @package tests\unit\models
 */
class SeoModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return SeoModel
	 */
	protected function getModel()
	{
		return new SeoModel;
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
		$this->assertEquals(1, SeoModel::model()->byUrl("texts")->find()->id);
	}
}