<?php

namespace testS\tests\unit\models;

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
            self::MODEL_EXCEPTION
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
                "gridLineId"  => "",
                "x"           => "",
                "y"           => "",
                "width"       => "",
                "contentType" => "",
                "contentId"   => "",
            ],
            self::MODEL_EXCEPTION
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
                "gridLineId"  => 1,
                "x"           => 0,
                "y"           => 0,
                "width"       => 12,
                "contentType" => 1,
                "contentId"   => 1,
            ],
            [
                "gridLineId"  => 1,
                "x"           => 0,
                "y"           => 0,
                "width"       => 12,
                "contentType" => 1,
                "contentId"   => 1,
            ],
            [
                "x"     => 6,
                "y"     => 1,
                "width" => 7,
            ],
            [
                "gridLineId"  => 1,
                "x"           => 6,
                "y"           => 1,
                "width"       => 6,
                "contentType" => 1,
                "contentId"   => 1,
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
                "gridLineId"  => 1,
                "x"           => 13,
                "y"           => -10,
                "width"       => 5,
                "contentType" => 1,
                "contentId"   => 1,
            ],
            [
                "gridLineId"  => 1,
                "x"           => 11,
                "y"           => 0,
                "width"       => 1,
                "contentType" => 1,
                "contentId"   => 1,
            ],
            [
                "gridLineId"  => "incorrect type",
                "x"           => "incorrect type",
                "y"           => "incorrect type",
                "width"       => "incorrect type",
                "contentType" => "incorrect type",
                "contentId"   => "incorrect type",
            ],
            self::MODEL_EXCEPTION
        ];
    }
}