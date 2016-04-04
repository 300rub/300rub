<?php

namespace tests\unit\models;

use models\DesignTextModel;

/**
 * Tests for model DesignTextModel
 *
 * @package tests\unit\models
 */
class DesignTextModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return DesignTextModel
	 */
	protected function getModel()
	{
		return new DesignTextModel;
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