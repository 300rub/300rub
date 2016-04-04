<?php

namespace tests\unit\models;

use models\UserModel;

/**
 * Tests for model SeoModel
 *
 * @package tests\unit\models
 */
class UserModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return UserModel
	 */
	protected function getModel()
	{
		return new UserModel;
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