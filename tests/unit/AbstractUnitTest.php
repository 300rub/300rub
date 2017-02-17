<?php

namespace testS\tests\unit;

use PHPUnit_Framework_TestCase;

/**
 * Class AbstractUnitTest
 *
 * @package testS\tests\unit
 */
abstract class AbstractUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Compares expected and actual
     *
     * @param array $expected
     * @param array $actual
     * @param bool  $isFullSame
     *
     * @return AbstractUnitTest
     */
    protected function compareExpectedAndActual(array $expected, array $actual, $isFullSame = false)
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

                $this->compareExpectedAndActual($expectedValue, $actual[$key], $isFullSame);
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

                $this->compareExpectedAndActual($actualValue, $expected[$key], $isFullSame);
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
}