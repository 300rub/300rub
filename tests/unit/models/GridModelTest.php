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
		return [
			// Insert: empty fields
			[
				[],
				[]
			],
			// Insert: empty values
			[
				[
					"t.grid_line_id" => "",
					"t.x"            => "",
					"t.y"            => "",
					"t.width"        => "",
					"t.content_type" => "",
					"t.content_id"   => "",
				],
				[]
			],
			// Insert: correct values. Update: correct values.
			[
				[
					"t.grid_line_id" => 1,
					"t.x"            => 0,
					"t.y"            => 0,
					"t.width"        => 12,
					"t.content_type" => 1,
					"t.content_id"   => 1,
				],
				[],
				[
					"t.grid_line_id" => 1,
					"t.x"            => 0,
					"t.y"            => 0,
					"t.width"        => 12,
					"t.content_type" => 1,
					"t.content_id"   => 1,
				],
				[
					"t.x"            => 6,
					"t.y"            => 1,
					"t.width"        => 7,
				],
				[],
				[
					"t.grid_line_id" => 1,
					"t.x"            => 6,
					"t.y"            => 1,
					"t.width"        => 6,
					"t.content_type" => 1,
					"t.content_id"   => 1,
				],
				[
					"gridLineModel"
				]
			],
			// Insert: incorrect values. Update: incorrect correct values.
			[
				[
					"t.grid_line_id" => 1,
					"t.x"            => 13,
					"t.y"            => -10,
					"t.width"        => 5,
					"t.content_type" => 1,
					"t.content_id"   => 1,
				],
				[],
				[
					"t.grid_line_id" => 1,
					"t.x"            => 11,
					"t.y"            => 0,
					"t.width"        => 1,
					"t.content_type" => 1,
					"t.content_id"   => 1,
				],
				[
					"t.grid_line_id" => "incorrect type",
					"t.x"            => "incorrect type",
					"t.y"            => "incorrect type",
					"t.width"        => "incorrect type",
					"t.content_type" => "incorrect type",
					"t.content_id"   => "incorrect type",
				],
				[]
			],
		];
	}
}