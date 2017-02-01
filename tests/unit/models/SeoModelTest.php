<?php

namespace testS\tests\unit\models;

use testS\models\SeoModel;

/**
 * Tests for the model SeoModel
 *
 * @package testS\tests\unit\models
 */
class SeoModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SeoModel
     */
    protected function getNewModel()
    {
        return new SeoModel();
    }

    /**
     * @param array $createData
     * @param array $createExpected
     *
     * @dataProvider dataProviderXRUD
     *
     * @return true
     */
    public function testCRUD(array $createData = [], $createExpected = [])
    {
        $model = $this->getNewModel()->set($createData)->save();

        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $this->_checkCRUDExpected($createExpected, $errors, true);
            return true;
        }

        return true;
    }

    private function _checkCRUDExpected(array $expected, array $actual, $isFullSame = false)
    {
        foreach ($expected as $key => $expectedValue) {
            if (is_string($key)) {
                $this->assertArrayHasKey(
                    $key,
                    $actual,
                    sprintf(
                        "Unable to find key [%s] in array with keys [%s]",
                        $key,
                        implode(", ", array_keys($actual))
                    )
                );
            } else {
                $this->assertTrue(
                    in_array($expectedValue, $actual),
                    sprintf(
                        "Unable to find value [%s] in array with values [%s]",
                        $expectedValue,
                        implode(", ", $actual)
                    )
                );
            }

            if (is_array($expectedValue)) {
                $this->assertTrue(
                    is_array($actual[$key]),
                    sprintf(
                        "Actual data with key [%s] is not an array. Array expected.",
                        $key
                    )
                );

                $this->_checkCRUDExpected($expectedValue, $actual[$key]);
                continue;
            }

            $this->assertSame($expectedValue, $actual[$key]);
        }

        return $this;
    }

    public function dataProviderXRUD()
    {
        return array_merge(
            $this->getDataProviderCRUDEmpty()
//            $this->getDataProviderCRUDCorrect(),
//            $this->getDataProviderCRUDIncorrect()
        );
    }

    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [
                    "name" => ["required"],
                    "url"  => ["require", "url"]
                ]
            ],
            "empty2" => [
                [
                    "name" => "",
                    "url"  => "",
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
                ]
            ],
            "empty3" => [
                [
                    "url"  => "Not empty 2",
                ],
                [
                    "name" => ["required"]
                ]
            ],
            "empty4" => [
                [
                    "name" => "Not empty 3"
                ],
                [
                    "a" => "b"
                ]
            ]
        ];
    }

    protected function getDataProviderCRUDCorrect()
    {
        return [
            []
        ];
    }

    protected function getDataProviderCRUDIncorrect()
    {
        return [
            []
        ];
    }
}