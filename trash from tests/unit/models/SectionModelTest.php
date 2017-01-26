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
                "designBlockModel" => [
                    "width"    => 1024
                ]
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
                "designBlockModel" => [
                    "width"    => 1024
                ]
            ],
            [
                "seoModel" => [
                    "name"        => "   seo name 2   ",
                    "url"         => "   ",
                    "title"       => "   seo title 2  ",
                    "keywords"    => "  seo keywords 2  ",
                    "description" => "  seo description 2   ",
                ],
                "designBlockModel" => [
                    "width"    => SectionModel::DEFAULT_WIDTH
                ]
            ],
            [
                "seoModel" => [
                    "name"        => "seo name 2",
                    "url"         => "seo-name-2",
                    "title"       => "seo title 2",
                    "keywords"    => "seo keywords 2",
                    "description" => "seo description 2",
                ],
                "language" => Language::LANGUAGE_EN_ID,
                "designBlockModel" => [
                    "width"    => SectionModel::DEFAULT_WIDTH
                ]
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
                "language" => 99
            ],
            [
                "seoModel" => [
                    "name"        => "seo name",
                    "url"         => "seo-url",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "seo description",
                ],
                "language" => Language::getActiveId()
            ],
            [
                "seoModel" => [
                    "name" => " <b>seo name! <b>",
                    "url"  => "",
                ],
                "language" => "incorrect language",
            ],
            [
                "seoModel" => [
                    "name"        => "seo name!",
                    "url"         => "seo-name",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "seo description",
                ],
                "language" => Language::getActiveId()
            ]
        ];
    }

    /**
     * Find by URL
     *
     * @param string   $url
     * @param int|null $id
     *
     * @dataProvider dataProviderForTestFindByUrl
     */
    public function testFindByUrl($url, $id)
    {
        $model = (new SectionModel)->byUrl($url)->find();

        if ($id === null) {
            $this->assertNull($model);
        } else {
            $this->assertEquals($id, $model->id);
        }
    }

    /**
     * Data provider for testFindByUrl
     *
     * @return array
     */
    public function dataProviderForTestFindByUrl()
    {
        return [
            ["texts", 1],
            ["", 1],
            ["not-exists", null]
        ];
    }
}