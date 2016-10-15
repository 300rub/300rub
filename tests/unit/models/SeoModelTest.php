<?php

namespace testS\tests\unit\models;

use testS\models\SeoModel;

/**
 * Tests for model SeoModelTes
 *
 * @package testS\tests\unit\models
 */
class SeoModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return SeoModel
     */
    protected function getModel()
    {
        return new SeoModel;
    }

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    public function dataProviderForCRUD()
    {
        return array_merge(
            $this->_dataProviderForCRUDNull(),
            $this->_dataProviderForCRUDEmpty(),
            $this->_dataProviderForCRUDCorrect(),
            $this->_dataProviderForCRUDIncorrect()
        );
    }

    /**
     * Insert: null data.
     *
     * @return array
     */
    private function _dataProviderForCRUDNull()
    {
        return [
            [
                [],
                [
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
                [
                    "name"        => "",
                    "url"         => "",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => "",
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"],
                ]
            ]
        ];
    }

    /**
     * Insert: correct values.
     * Update: with more than max values.
     *
     * @return array
     */
    private function _dataProviderForCRUDCorrect()
    {
        return [
            [
                [
                    "name"        => "name",
                    "url"         => "url",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description",
                ],
                [],
                [
                    "name"        => "name",
                    "url"         => "url",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description",
                ],
                [
                    "name"        => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "url"         => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "title"       => "string with length more than 100 symbols,
						string with length more than 100 symbols, string with length more than 100 symbols,
						string with length more than 100 symbols",
                    "keywords"    => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "description" => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                ],
                [
                    "name"        => ["max"],
                    "url"         => ["max"],
                    "title"       => ["max"],
                    "keywords"    => ["max"],
                    "description" => ["max"],
                ],
            ],
        ];
    }

    /**
     * Insert: incorrect values.
     * Update: incorrect correct values.
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrect()
    {
        return [
            [
                [
                    "name"        => " <b>seo name<b>",
                    "url"         => "<i>seo-url<i> &^ &^) &^£&",
                    "title"       => "<div>seo title</div>",
                    "keywords"    => "<div>seo keywords<div>",
                    "description" => "<div>seo description<div>",
                ],
                [],
                [
                    "name"        => "seo name",
                    "url"         => "seo-url",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "seo description",
                ],
                [
                    "name" => " <b>seo name! <b>",
                    "url"  => "",
                ],
                [],
                [
                    "name"        => "seo name!",
                    "url"         => "seo-name",
                    "title"       => "seo title",
                    "keywords"    => "seo keywords",
                    "description" => "seo description",
                ]
            ],
        ];
    }

    /**
     * Find by URL
     */
    public function testFindByUrl()
    {
        $this->markTestSkipped("Fixtures");
        $this->assertEquals(1, SeoModel::model()->byUrl("texts")->find()->id);
    }
}