<?php

namespace tests\unit\models;

use models\DesignBlockModel;

/**
 * Tests for model DesignTextModel
 *
 * @package tests\unit\models
 */
class DesignBlockModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return DesignBlockModel
	 */
	protected function getModel()
	{
		return new DesignBlockModel;
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