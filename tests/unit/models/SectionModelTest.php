<?php

namespace tests\unit\models;

use components\Language;
use models\GridLineModel;
use models\GridModel;
use models\SectionModel;

/**
 * Tests for model SectionModel
 *
 * @package tests\unit\models
 */
class SectionModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return SectionModel
	 */
	protected function getModel()
	{
		return new SectionModel;
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
				[
					"seoModel.name" => "required",
					"seoModel.url"  => "required",
				]
			],
			// Insert: empty values
			[
				[
					"t.seo_id"          => "",
					"t.language"        => "",
					"t.width"           => "",
					"t.is_main"         => "",
					"t.design_block_id" => "",
				],
				[
					"seoModel.name" => "required",
					"seoModel.url"  => "required",
				]
			],
			// Insert: correct values. Update: correct values.
			[
				[
					"seoModel.name"        => "seo name",
					"seoModel.url"         => "seo-url",
					"seoModel.title"       => "seo title",
					"seoModel.keywords"    => "seo keywords",
					"seoModel.description" => "seo description",
					"t.language"           => Language::LANGUAGE_EN_ID,
					"t.width"              => 1024
				],
				[],
				[
					"seoModel.name"        => "seo name",
					"seoModel.url"         => "seo-url",
					"seoModel.title"       => "seo title",
					"seoModel.keywords"    => "seo keywords",
					"seoModel.description" => "seo description",
					"t.language"           => Language::LANGUAGE_EN_ID,
					"t.width"              => 1024
				],
				[
					"seoModel.name"        => "   seo name 2   ",
					"seoModel.title"       => "   seo title 2  ",
					"seoModel.keywords"    => "  seo keywords 2  ",
					"seoModel.description" => "  seo description 2   ",
					"t.width"              => SectionModel::DEFAULT_WIDTH
				],
				[],
				[
					"seoModel.name"        => "seo name 2",
					"seoModel.url"         => "seo-name-2",
					"seoModel.title"       => "seo title 2",
					"seoModel.keywords"    => "seo keywords 2",
					"seoModel.description" => "seo description 2",
					"t.language"           => Language::LANGUAGE_EN_ID,
					"t.width"              => SectionModel::DEFAULT_WIDTH
				]
			],
			// Insert: incorrect values. Update: incorrect correct values.
			[
				[
					"seoModel.name"        => " <b>seo name<b>",
					"seoModel.url"         => "<i>seo-url<i> &^ &^) &^£&",
					"seoModel.title"       => "<div>seo title</div>",
					"seoModel.keywords"    => "<div>seo keywords<div>",
					"seoModel.description" => "<div>seo description<div>",
					"t.language"           => 99,
					"t.width"              => -100
				],
				[],
				[
					"seoModel.name"        => "seo name",
					"seoModel.url"         => "seo-ur",
					"seoModel.title"       => "seo title",
					"seoModel.keywords"    => "seo keywords",
					"seoModel.description" => "seo description",
					"t.language"           => Language::$activeId,
					"t.width"              => SectionModel::DEFAULT_WIDTH
				],
				[
					"seoModel.name"        => " <b>seo name! <b>",
					"seoModel.url"         => "",
					"t.language"           => "incorrect language",
					"t.width"              => "incorrect width"
				],
				[],
				[
					"seoModel.name"        => "seo name!",
					"seoModel.url"         => "seo-name",
					"seoModel.title"       => "seo title",
					"seoModel.keywords"    => "seo keywords",
					"seoModel.description" => "seo description",
					"t.language"           => Language::$activeId,
					"t.width"              => SectionModel::DEFAULT_WIDTH
				]
			],
		];
	}

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
		$this->assertEquals(1, SectionModel::model()->byUrl("texts")->find()->id);
	}

	/**
	 * Duplicate test
	 */
	public function testDuplicate()
	{
		$idForCopy = 1;
		$model = $this->getModel()->byId($idForCopy)->find();
		$this->assertNotNull($model);

		$modelAfterDuplicate = $model->duplicate();
		$this->assertNotNull($modelAfterDuplicate);

		$modelForCopy = $this->getModel()->withAll()->byId($idForCopy)->find();
		$modelCopy = $this->getModel()->withAll()->byId($modelAfterDuplicate->id)->find();

		$this->assertNotEquals($modelForCopy->id, $modelCopy->id);
		$this->assertNotEquals($modelForCopy->seo_id, $modelCopy->seo_id);
		$this->assertEquals(0, $modelCopy->is_main);
		$this->assertNotEquals($modelForCopy->design_block_id, $modelCopy->design_block_id);
		$this->assertEquals($modelForCopy->language, $modelCopy->language);
		$this->assertEquals($modelForCopy->width, $modelCopy->width);

		foreach ($modelForCopy->designBlockModel->getFieldNames() as $field) {
			$this->assertEquals($modelForCopy->designBlockModel->$field, $modelCopy->designBlockModel->$field);
		}

		$gridLinesForCopy = GridLineModel::model()->bySectionId($modelForCopy->id)->withAll()->findAll();
		$gridLinesCopy = GridLineModel::model()->bySectionId($modelCopy->id)->withAll()->findAll();
		$this->assertEquals(count($gridLinesForCopy), count($gridLinesCopy));

		foreach ($gridLinesForCopy as $key => $gridLineForCopy) {
			$this->assertArrayHasKey($key, $gridLinesCopy);
			$gridLineCopy = $gridLinesCopy[$key];
			$this->assertEquals($gridLineForCopy->sort, $gridLineCopy->sort);

			$gridsForCopy = GridModel::model()->byLineId($gridLineForCopy->id)->findAll();
			$gridsCopy = GridModel::model()->byLineId($gridLineCopy->id)->findAll();
			$this->assertEquals(count($gridsForCopy), count($gridsCopy));

			foreach ($gridsForCopy as $keyGrid => $gridForCopy) {
				$this->assertArrayHasKey($keyGrid, $gridsCopy);
				$gridCopy = $gridsCopy[$key];
				$this->assertNotEquals($gridForCopy->grid_line_id, $gridCopy->grid_line_id);
				$this->assertEquals($gridForCopy->x, $gridCopy->x);
				$this->assertEquals($gridForCopy->y, $gridCopy->y);
				$this->assertEquals($gridForCopy->width, $gridCopy->width);
				$this->assertEquals($gridForCopy->content_type, $gridCopy->content_type);
				$this->assertEquals($gridForCopy->content_id, $gridCopy->content_id);
			}
		}

		$this->assertTrue($modelCopy->delete());
	}
}