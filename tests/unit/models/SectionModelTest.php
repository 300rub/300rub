<?php

namespace tests\unit\models;

use models\SectionModel;

/**
 * Тест для модели SectionModel
 *
 * @package tests.unit.models
 */
class SectionModelTest extends AbstractModelTest
{

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
		$this->assertEquals(1, SectionModel::model()->byUrl("texts")->find()->id);
	}

	/**
	 * CRUD
	 *
	 * @param array $createData
	 * @param array $createExpected
	 * @param array $createErrors
	 * @param array $updateData
	 * @param array $updateExpected
	 * @param array $updateErrors
	 *
	 * @dataProvider dataProviderForCRUD
	 */
	public function testCRUD($createData, $createExpected, $createErrors, $updateData, $updateExpected, $updateErrors)
	{
		$model = new SectionModel;
		$model->setAttributes($createData);
		$this->assertEquals(true, $model->save());
	}

	public function dataProviderForCRUD()
	{
		return [
			[
				[
					"t.seo_id"          => 1,
					"t.language"        => 1,
					"t.width"           => 980,
					"t.is_main"         => 1,
					"t.design_block_id" => 9
				],
				[
					"t.seo_id"          => 1,
					"t.language"        => 1,
					"t.width"           => 980,
					"t.is_main"         => 1,
					"t.design_block_id" => 9
				],
				[],
				[
					"t.width"  => 980,
				],
				[
					"t.width"  => 980,
				],
				[],
			]
		];
	}
}