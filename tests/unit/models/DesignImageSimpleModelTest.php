<?php

namespace testS\tests\unit\models;

use testS\models\DesignImageSimpleModel;

/**
 * Tests for the model DesignImageSimpleModel
 *
 * @package testS\tests\unit\models
 */
class DesignImageSimpleModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSimpleModel
     */
    protected function getNewModel()
    {
        return new DesignImageSimpleModel();
    }

    public function testA()
    {
        $response = [
            "t_name" => "t_name_value",
            "t_surname" => "t_surname_value",
            "house_age" => "t_house_age_value",
            "house_number" => "t_house_number_value",
            "house_street_name" => "t_house_street_name_value",
            "house_street_city_name" => "house_street_city_name_value",
        ];


        var_dump($this->_parseDbResponse($response));

        $a = [
            "a" => "b",
            "c" => "d"
        ];
        $b = [
            "e" => [
                "f" => "g"
            ]
        ];
        var_dump(array_merge($a, $b));
    }

    private function _parseDbResponse(array $response)
    {
        $fields = [];

        foreach ($response as $fullFieldName => $value) {
            list($alias, $field) = explode("_", $fullFieldName, 2);

            if ($alias === "t") {
                $fields[$field] = $value;
                continue;
            }

            if (!isset($fields[$alias])) {
                $fields[$alias] = [];
            }

            if (strripos($field, "_")) {
                list($alias2, $field2) = explode("_", $field, 2);

                if (!isset($fields[$alias][$alias2])) {
                    $fields[$alias][$alias2] = [];
                }

                if (strripos($field2, "_")) {
                    list($alias3, $field3) = explode("_", $field2, 2);

                    if (!isset($fields[$alias][$alias2][$alias3])) {
                        $fields[$alias][$alias2][$alias3] = [];
                    }

                    $fields[$alias][$alias2][$alias3][$field3] = $value;
                } else {
                    $fields[$alias][$alias2][$field2] = $value;
                }
            } else {
                $fields[$alias][$field] = $value;
            }
        }

        return $fields;
    }
}