<?php

namespace tests\unit\models;

use models\GridLineModel;

/**
 * Tests for model GridModel
 *
 * @package tests\unit\models
 */
class GridLineModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return GridLineModel
	 */
	protected function getModel()
	{
		return new GridLineModel;
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
}