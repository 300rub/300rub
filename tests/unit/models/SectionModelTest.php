<?php

namespace testS\tests\unit\models;

use testS\components\Language;
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
            $this->_dataProviderForCRUDNull(),
            $this->_dataProviderForCRUDEmpty(),
            $this->_dataProviderForCRUDCorrect(),
            $this->_dataProviderForCRUDIncorrect()
        ];
    }

    /**
     * Insert: null data.
     *
     * @return array
     */
    private function _dataProviderForCRUDNull()
    {
        return [
            [],
            [
                "seoModel" => [
                    "name" => ["required"],
                    "url"  => ["required", "url"],
                ]
            ]
        ];
    }

    /**
     * Insert: empty data.
     *
     * @return array
     */
    private function _dataProviderForCRUDEmpty()
    {
        return [
            [
                "seoId"         => "",
                "language"      => "",
                "width"         => "",
                "isMain"        => "",
                "designBlockId" => "",
            ],
            [
                "seoModel" => [
                    "name" => ["required"],
                    "url"  => ["required", "url"],
                ]
            ]
        ];
    }

    /**
     * Insert: correct values.
     * Update: correct values.
     *
     * @return array
     */
    private function _dataProviderForCRUDCorrect()
    {
        return [
            [
                "seoModel" => [
                    "name"        => "seo name",
                    "url"         => "seo-url",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "description"
                ],
                "language" => Language::LANGUAGE_EN_ID,
                "width"    => 1024
            ],
            [
                "seoModel" => [
                    "name"        => "seo name",
                    "url"         => "seo-url",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "description"
                ],
                "language" => Language::LANGUAGE_EN_ID,
                "width"    => 1024
            ],
            [
                "seoModel" => [
                    "name"        => "   seo name 2   ",
                    "url"         => "   ",
                    "title"       => "   seo title 2  ",
                    "keywords"    => "  seo keywords 2  ",
                    "description" => "  seo description 2   ",
                ],
                "width"              => SectionModel::DEFAULT_WIDTH
            ],
            [
                "seoModel" => [
                    "name"        => "seo name 2",
                    "url"         => "seo-name-2",
                    "title"       => "seo title 2",
                    "keywords"    => "seo keywords 2",
                    "description" => "seo description 2",
                ],
                "language"           => Language::LANGUAGE_EN_ID,
                "width"              => SectionModel::DEFAULT_WIDTH
            ]
        ];
    }

    /**
     * Insert: incorrect values.
     * Update: incorrect values.
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrect()
    {
        return [
            [
                "seoModel" => [
                    "name"        => " <b>seo name<b>",
                    "url"         => "<i>seo-url<i> &^ &^) &^£&",
                    "title"       => "<div>seo title</div>",
                    "keywords"    => "<div>seo keywords<div>",
                    "description" => "<div>seo description<div>",
                ],
                "language"           => 99,
                "width"              => -100
            ],
            [
                "seoModel" => [
                    "name"        => "seo name",
                    "url"         => "seo-url",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "seo description",
                ],
                "language"           => Language::$activeId,
                "width"              => SectionModel::DEFAULT_WIDTH
            ],
            [
                "seoModel" => [
                    "name"        => " <b>seo name! <b>",
                    "url"         => "",
                ],
                "language"           => "incorrect language",
                "width"              => "incorrect width"
            ],
            [
                "seoModel" => [
                    "name"        => "seo name!",
                    "url"         => "seo-name",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "seo description",
                ],
                "language"           => Language::$activeId,
                "width"              => SectionModel::DEFAULT_WIDTH
            ]
        ];
    }

	/**
	 * Find by URL
	 */
	public function testFindByUrl()
	{
		$this->assertEquals(1, (new SectionModel)->byUrl("texts")->find()->id);
	}
}