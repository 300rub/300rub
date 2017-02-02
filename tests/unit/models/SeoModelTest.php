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
     * @param array $updateData
     * @param array $updateExpected
     *
     * @dataProvider dataProviderXRUD
     *
     * @return true
     */
    public function testCRUD(
        array $createData = [],
        array $createExpected = [],
        array $updateData = [],
        array $updateExpected = []
    )
    {
        $model = $this->getNewModel()->set($createData)->save();
        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $this->_checkCRUDExpected($createExpected, $errors, true);
            return true;
        }
        $this->_checkCRUDExpected($createExpected, $model->get());

        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->assertInstanceOf("\\testS\\models\\AbstractModel", $model);
        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->_checkCRUDExpected($createExpected, $model->get());

        $model->set($updateData)->save();
        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $this->_checkCRUDExpected($updateExpected, $errors, true);
            return true;
        }
        $this->_checkCRUDExpected($updateExpected, $model->get());

        $model->delete();
        $model = $this->getNewModel()->byId($model->getId())->find();
        $this->assertNull($model);

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
                        "Unable to find key [%s] in actual array with keys [%s]",
                        $key,
                        implode(", ", array_keys($actual))
                    )
                );
            } else {
                $this->assertTrue(
                    in_array($expectedValue, $actual),
                    sprintf(
                        "Unable to find value [%s] in actual array with values [%s]",
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

                $this->_checkCRUDExpected($expectedValue, $actual[$key], $isFullSame);
                continue;
            }

            $this->assertSame(
                $expectedValue,
                $actual[$key],
                sprintf("Values with key [%s] are not the same", $key)
            );
        }

        if ($isFullSame === false) {
            return $this;
        }

        foreach ($actual as $key => $actualValue) {
            if (is_string($key)) {
                $this->assertArrayHasKey(
                    $key,
                    $expected,
                    sprintf(
                        "Unable to find key [%s] in expected array with keys [%s]",
                        $key,
                        implode(", ", array_keys($expected))
                    )
                );
            } else {
                $this->assertTrue(
                    in_array($actualValue, $expected),
                    sprintf(
                        "Unable to find value [%s] in expected array with values [%s]",
                        $actualValue,
                        implode(", ", $expected)
                    )
                );
            }

            if (is_array($actualValue)) {
                $this->assertTrue(
                    is_array($expected[$key]),
                    sprintf(
                        "Expected data with key [%s] is not an array. Array expected.",
                        $key
                    )
                );

                $this->_checkCRUDExpected($actualValue, $expected[$key], $isFullSame);
                continue;
            }

            $this->assertSame(
                $actualValue,
                $expected[$key],
                sprintf("Values with key [%s] are not the same", $key)
            );
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
                    "url"  => ["required", "url"]
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
                    "url" => "Not empty",
                ],
                [
                    "name" => ["required"]
                ]
            ],
            "empty4" => [
                [
                    "name" => "Not empty"
                ],
                [
                    "name"        => "Not empty",
                    "url"         => "not-empty",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => "",
                ]
            ],
            "empty5" => [
                [
                    "name"        => "     Not empty        ",
                    "url"         => "     Not empty     url     ",
                    "title"       => "         ",
                    "keywords"    => "          ",
                    "description" => "          "
                ],
                [
                    "name"        => "Not empty",
                    "url"         => "not-empty-----url",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => "",
                ],
                [
                    "name"     => " Not empty 2 ",
                    "url"      => "",
                    "keywords" => "keywords",
                ],
                [
                    "name"        => "Not empty 2",
                    "url"         => "not-empty-2",
                    "title"       => "",
                    "keywords"    => "keywords",
                    "description" => ""
                ],
            ],
            "empty6" => [
                [
                    "name" => "Not empty",
                ],
                [
                    "name" => "Not empty",
                    "url"  => "not-empty",
                ],
                [
                    "name" => "",
                    "url"  => "",
                ],
                [
                    "name" => ["required"],
                    "url"  => ["required", "url"]
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