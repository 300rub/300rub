<?php

namespace tests\unit\models;

use models\SeoModel;

/**
 * Tests for model SeoModelTest.
 *
 * @package tests\unit\models
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
        return [
            // Insert: empty fields
            [
                [],
                [
                    "t.name" => "required",
                    "t.url"  => "required",
                ]
            ],
            // Insert: empty values
            [
                [
                    "t.name"        => "",
                    "t.url"         => "",
                    "t.title"       => "",
                    "t.keywords"    => "",
                    "t.description" => "",
                ],
                [
                    "t.name" => "required",
                    "t.url"  => "required",
                ]
            ],
            // Insert: correct values. Update: with more than max values.
            [
                [
                    "t.name"        => "name",
                    "t.url"         => "url",
                    "t.title"       => "title",
                    "t.keywords"    => "keywords",
                    "t.description" => "description",
                ],
                [],
                [
                    "t.name"        => "name",
                    "t.url"         => "url",
                    "t.title"       => "title",
                    "t.keywords"    => "keywords",
                    "t.description" => "description",
                ],
                [
                    "t.name"        => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "t.url"         => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "t.title"       => "string with length more than 100 symbols,
						string with length more than 100 symbols, string with length more than 100 symbols,
						string with length more than 100 symbols",
                    "t.keywords"    => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                    "t.description" => "string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols,
						string with length more than 255 symbols, string with length more than 255 symbols",
                ],
                [
                    "t.name"        => "max",
                    "t.url"         => "max",
                    "t.title"       => "max",
                    "t.keywords"    => "max",
                    "t.description" => "max",
                ],
            ],
            // Insert: incorrect values. Update: incorrect correct values.
            [
                [
                    "t.name"        => " <b>seo name<b>",
                    "t.url"         => "<i>seo-url<i> &^ &^) &^£&",
                    "t.title"       => "<div>seo title</div>",
                    "t.keywords"    => "<div>seo keywords<div>",
                    "t.description" => "<div>seo description<div>",
                ],
                [],
                [
                    "t.name"        => "seo name",
                    "t.url"         => "seo-url",
                    "t.title"       => "seo title",
                    "t.keywords"    => "seo keywords",
                    "t.description" => "seo description",
                ],
                [
                    "t.name" => " <b>seo name! <b>",
                    "t.url"  => "",
                ],
                [],
                [
                    "t.name"        => "seo name!",
                    "t.url"         => "seo-name",
                    "t.title"       => "seo title",
                    "t.keywords"    => "seo keywords",
                    "t.description" => "seo description",
                ]
            ],
        ];
    }

    /**
     * Find by URL
     */
    public function testFindByUrl()
    {
        $this->assertEquals(1, SeoModel::model()->byUrl("texts")->find()->id);
    }
}