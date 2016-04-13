<?php

namespace tests\unit\models;

use components\Language;
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
}