<?php

namespace testS\tests\unit;

use PHPUnit_Framework_TestCase;
use DateTime;
use testS\commands\RollbackSqlDumpsCommand;
use testS\models\AbstractModel;

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
    const TOKEN_OWNER = "c4ca4238a0b923820dcc509a6f75849b";
    const TOKEN_FULL = "c81e728d9d4c2f636f067f89cc14862c";
    const TOKEN_LIMITED = "eccbc87e4b5ce2fe28308fd9f2a7baf3";
    const TOKEN_NO_OPERATION_USER = "a87ff679a2f3e71d9181a67b7542122c";
    const TOKEN_BLOCKED_USER = "fkr8eur9a2f3e71d9181a67b7w94mfur";

    /**
     * Session IDs
     */
    const SESSION_ID_OWNER = "a87ff679a2f3e71d9181a67b7542122c";
    const SESSION_ID_FULL = "e4da3b7fbbce2345d7772b0674a318d5";
    const SESSION_ID_LIMITED = "1679091c5a880faf6fb5e6087eb1b2dc";
    const SESSION_NO_OPERATION_USER = "011ecee7d295c066ae68d4396215c3d0";
    const SESSION_BLOCKED_USER = "krieu457d295c066ae68d4396mkdurn5";

    /**
     * Exceptions
     */
    const EXCEPTION_MODEL = "testS\\components\\exceptions\\ModelException";
    const EXCEPTION_CONTENT = "testS\\components\\exceptions\\ContentException";

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
                if (is_array($expectedValue)) {
                    $this->compareExpectedAndActual($expectedValue, $actual[$key]);
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
            }

            if (is_array($expectedValue)) {
                /**
                 * @var AbstractModel|array $actualValue
                 */
                $actualValue = $actual[$key];
                if ($actualValue instanceof AbstractModel) {
                    $actualValue = $actualValue->get();
                }

                $this->assertTrue(
                    is_array($actualValue),
                    sprintf(
                        "Actual data with key [%s] is not an array. Array expected.",
                        $key
                    )
                );


                $this->compareExpectedAndActual($expectedValue, $actualValue, $isFullSame);
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
                if (is_array($actualValue)) {
                    $this->assertArrayHasKey(
                        $key,
                        $expected,
                        sprintf(
                            "Unable to find key [%s] in expected array",
                            $key
                        )
                    );
                    $this->compareExpectedAndActual($actualValue, $expected[$key]);
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

    /**
     * Resets DB
     *
     * @return AbstractUnitTest
     */
    protected function resetDb()
    {
        RollbackSqlDumpsCommand::rollbackDumps();
        return $this;
    }

    /**
     * Generates random string
     *
     * @param string $length
     *
     * @return string
     */
    protected function generateStringWithLength($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}