<?php

namespace testS\tests\unit\models;

use testS\models\SettingsModel;

/**
 * Tests for the model SettingModel
 *
 * @package testS\tests\unit\models
 */
class SettingsModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SettingsModel
     */
    protected function getNewModel()
    {
        return new SettingsModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            "empty2" => [
                [
                    "type"  => "",
                    "value" => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            "empty3" => [
                [
                    "type"  => null,
                    "value" => null,
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            "empty4" => [
                [
                    "value" => "111",
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            "empty5" => [
                [
                    "type" => "icon",
                ],
                [
                    "value" => ["required"]
                ],
            ],
            "empty6" => [
                [
                    "type"  => "icon",
                    "value" => "",
                ],
                [
                    "value" => ["required"]
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        return [
            "correct1" => [
                [
                    "type"  => "icon",
                    "value" => "file_path.ico"
                ],
                [
                    "type"  => "icon",
                    "value" => "file_path.ico"
                ],
                [
                    "value" => "new_file_path.ico"
                ],
                [
                    "type"  => "icon",
                    "value" => "new_file_path.ico"
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [
            "incorrect1" => [
                [
                    "type"  => "incorrect",
                    "value" => "value"
                ],
                [],
                [],
                [],
                self::EXCEPTION_CONTENT
            ],
            "incorrect2" => [
                [
                    "type"  => "icon",
                    "value" => "icon_file_path.ico"
                ],
                [
                    "type"  => "icon",
                    "value" => "icon_file_path.ico"
                ],
                [
                    "type"  => "appleTouchIcon57",
                    "value" => "apple_icon_file_path.png"
                ],
                [
                    "type"  => "icon",
                    "value" => "apple_icon_file_path.png"
                ]
            ],
            "incorrect3" => [
                [
                    "type"  => "icon",
                    "value" => $this->generateStringWithLength(256)
                ],
                [
                    "value" => ["maxLength"]
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "type"  => "icon",
                "value" => "icon_file_path.ico"
            ],
            [],
            self::EXCEPTION_CONTENT
        );
    }
}