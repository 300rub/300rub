<?php

namespace testS\tests\unit\models;

use testS\components\Language;
use testS\models\GridLineModel;
use testS\models\GridModel;
use testS\models\SectionModel;

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
					"t.seoId"          => "",
					"t.language"        => "",
					"t.width"           => "",
					"t.isMain"         => "",
					"t.designBlockId" => "",
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
					"seoModel.url"         => "   ",
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
					"seoModel.url"         => "seo-url",
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
			// Insert: long values. Update: correct values.
			[
				[
					"seoModel.name"        => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
					"seoModel.url"         => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
					"seoModel.title"       => "string with length more than 100 symbols,
						string with length more than 100 symbols, string with length more than 100 symbols,
						string with length more than 100 symbols",
					"seoModel.keywords"    => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
					"seoModel.description" => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
					"t.language"           => Language::LANGUAGE_EN_ID,
					"t.width"              => 1024
				],
				[
					"seoModel.name"        => "max",
					"seoModel.url"         => "max",
					"seoModel.title"       => "max",
					"seoModel.keywords"    => "max",
					"seoModel.description" => "max",
				],
				[],
				[
					"seoModel.name"        => "   seo name 2   ",
					"seoModel.url"         => "   ",
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
		];
	}

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
	    $this->markTestSkipped();
		$this->assertEquals(1, SectionModel::model()->byUrl("texts")->find()->id);
	}
}