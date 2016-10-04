<?php

namespace tests\unit\models;

use testS\models\GridModel;

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
		return [
			// Insert: empty fields
			[
				[],
				[]
			],
			// Insert: empty values
			[
				[
					"t.gridLineId" => "",
					"t.x"            => "",
					"t.y"            => "",
					"t.width"        => "",
					"t.contentType" => "",
					"t.contentId"   => "",
				],
				[]
			],
			// Insert: correct values. Update: correct values.
			[
				[
					"t.gridLineId" => 1,
					"t.x"            => 0,
					"t.y"            => 0,
					"t.width"        => 12,
					"t.contentType" => 1,
					"t.contentId"   => 1,
				],
				[],
				[
					"t.gridLineId" => 1,
					"t.x"            => 0,
					"t.y"            => 0,
					"t.width"        => 12,
					"t.contentType" => 1,
					"t.contentId"   => 1,
				],
				[
					"t.x"            => 6,
					"t.y"            => 1,
					"t.width"        => 7,
				],
				[],
				[
					"t.gridLineId" => 1,
					"t.x"            => 6,
					"t.y"            => 1,
					"t.width"        => 6,
					"t.contentType" => 1,
					"t.contentId"   => 1,
				],
				[
					"gridLineModel"
				]
			],
			// Insert: incorrect values. Update: incorrect correct values.
			[
				[
					"t.gridLineId" => 1,
					"t.x"            => 13,
					"t.y"            => -10,
					"t.width"        => 5,
					"t.contentType" => 1,
					"t.contentId"   => 1,
				],
				[],
				[
					"t.gridLineId" => 1,
					"t.x"            => 11,
					"t.y"            => 0,
					"t.width"        => 1,
					"t.contentType" => 1,
					"t.contentId"   => 1,
				],
				[
					"t.gridLineId" => "incorrect type",
					"t.x"            => "incorrect type",
					"t.y"            => "incorrect type",
					"t.width"        => "incorrect type",
					"t.contentType" => "incorrect type",
					"t.contentId"   => "incorrect type",
				],
				[]
			],
		];
	}
}