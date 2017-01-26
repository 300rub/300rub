<?php

namespace testS\tests\unit\models;

use testS\models\DesignImageSimpleModel;

/**
 * Tests for model DesignImageSimpleModel
 *
 * @package testS\tests\unit\models
 */
class DesignImageSimpleModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return DesignImageSimpleModel
     */
    protected function getModel()
    {
        return new DesignImageSimpleModel();
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
            $this->_dataProviderForCRUDIncorrectType(),
            $this->_dataProviderForCRUDIncorrectValue()
        ];
    }

    /**
     * Insert: null fields.
     * Update: null fields.
     *
     * @return array
     */
    private function _dataProviderForCRUDNull()
    {
        return [
            [],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ],
            [],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ]
        ];
    }

    /**
     * Insert: empty values.
     * Update: empty values.
     *
     * @return array
     */
    private function _dataProviderForCRUDEmpty()
    {
        return [
            [
                "designBlockId"      => "",
                "imageDesignBlockId" => "",
                "designTextId"       => "",
                "alignment"          => "",
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ],
            [
                "designBlockId"      => "",
                "imageDesignBlockId" => "",
                "designTextId"       => "",
                "alignment"          => "",
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
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
                "alignment" => DesignImageSimpleModel::ALIGNMENT_RIGHT,
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_RIGHT,
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_CENTER,
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_CENTER,
            ]
        ];
    }

    /**
     * Insert: values with incorrect type.
     * Update: values with incorrect type
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrectType()
    {
        return [
            [
                "alignment" => "incorrect",
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ],
            [
                "alignment" => "incorrect",
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ]
        ];
    }

    /**
     * Insert: incorrect values.
     * Update: incorrect values.
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrectValue()
    {
        return [
            [
                "alignment" => 999,
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ],
            [
                "alignment" => -10,
            ],
            [
                "alignment" => DesignImageSimpleModel::ALIGNMENT_LEFT,
            ]
        ];
    }
}