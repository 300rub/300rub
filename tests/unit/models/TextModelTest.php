<?php

namespace tests\unit\models;

use models\TextModel;

/**
 * Tests for model TextModel
 *
 * @package tests\unit\models
 */
class TextModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return TextModel
	 */
	protected function getModel()
	{
		return new TextModel;
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