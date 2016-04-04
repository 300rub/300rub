<?php

namespace tests\unit\models;

use models\GridModel;

/**
 * Tests for model GridModel
 *
 * @package tests\unit\models
 */
class GridModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return GridModel
	 */
	protected function getModel()
	{
		return new GridModel;
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