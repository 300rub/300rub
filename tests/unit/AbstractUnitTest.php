<?php

namespace testS\tests\unit;

use PHPUnit_Framework_TestCase;
use DateTime;

/**
 * Class AbstractUnitTest
 *
 * @package testS\tests\unit
 */
abstract class AbstractUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * User agents
     */
    const UA_FIREFOX_4_0_1 = "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1";
    const UA_CHROME_53_0 = "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) " .
        "Chrome/53.0.2785.92 Safari/537.36";

    /**
     * Tokens
     */
    const TOKEN_USER = "user8765c2c128f53f550c5ccbf2115b";
    const TOKEN_ADMIN = "admin765c2c128f53f550c5ccbf2115b";
    const TOKEN_OWNER = "owner765c2c128f53f550c5ccbf2115b";

    /**
     * Exceptions
     */
    const EXCEPTION_MODEL = "testS\\components\\exceptions\\ModelException";

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

            /**
             * @var DateTime $dateTime
             */
            if ($actual[$key] instanceof DateTime) {
                $dateTime = $actual[$key];
                $expectedDateTime = new DateTime($expectedValue);
                $this->assertTrue(
                    $dateTime->getTimestamp() % $expectedDateTime->getTimestamp() < 5,
                    sprintf(
                        "Values with key [%s] are not the same. Expected: [%s], actual: [%s]",
                        $key,
                        $expectedDateTime->format("Y-m-d H:i:s"),
                        $dateTime->format("Y-m-d H:i:s")
                    )
                );

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