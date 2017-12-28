<?php

namespace testS\tests\unit\_abstract;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract class to work with unit tests
 */
abstract class AbstractUnitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * User agents
     */
    const UA_FIREFOX_4_0_1
        = "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1)' . 
            ' Gecko/20100101 Firefox/4.0.1";
    const UA_CHROME_53_0
        = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36'.
            ' (KHTML, like Gecko) Chrome/53.0.2785.92 Safari/537.36';

    /**
     * Tokens
     */
    const TOKEN_OWNER = 'c4ca4238a0b923820dcc509a6f75849b';
    const TOKEN_FULL = 'c81e728d9d4c2f636f067f89cc14862c';
    const TOKEN_LIMITED = 'eccbc87e4b5ce2fe28308fd9f2a7baf3';
    const TOKEN_NO_OPERATION_USER = 'a87ff679a2f3e71d9181a67b7542122c';
    const TOKEN_BLOCKED_USER = 'fkr8eur9a2f3e71d9181a67b7w94mfur';

    /**
     * Session IDs
     */
    const SESSION_ID_OWNER = 'a87ff679a2f3e71d9181a67b7542122c';
    const SESSION_ID_FULL = 'e4da3b7fbbce2345d7772b0674a318d5';
    const SESSION_ID_LIMITED = '1679091c5a880faf6fb5e6087eb1b2dc';
    const SESSION_NO_OPERATION_USER = '011ecee7d295c066ae68d4396215c3d0';
    const SESSION_BLOCKED_USER = 'krieu457d295c066ae68d4396mkdurn5';

    /**
     * Exceptions
     */
    const EXCEPTION_MODEL
        = "testS\\application\\exceptions\\ModelException";
    const EXCEPTION_CONTENT
        = "testS\\application\\exceptions\\ContentException";

    /**
     * Compares expected and actual
     *
     * @param array $expected   Expected
     * @param array $actual     Actual
     * @param bool  $isFullSame Flag of full comparing
     *
     * @return AbstractUnitTest
     */
    protected function compareExpectedAndActual(
        array $expected,
        array $actual,
        $isFullSame = null
    ) {
        foreach ($expected as $key => $expectedValue) {
            $this->_compareKey($key, $expectedValue, $actual, 'actual');

            if (is_array($expectedValue) === true) {
                $this->_compareArray(
                    $key,
                    $expectedValue,
                    $actual,
                    $isFullSame,
                    'actual'
                );
                continue;
            }

            if ($actual[$key] instanceof \DateTime) {
                $this->_compareDateTime($actual[$key], $key, $expectedValue);
                continue;
            }

            $this->assertSame(
                $expectedValue,
                $actual[$key],
                sprintf('Values with key [%s] are not the same', $key)
            );
        }

        if ($isFullSame !== true) {
            return $this;
        }

        foreach ($actual as $key => $actualValue) {
            $this->_compareKey($key, $actualValue, $expected, 'expected');

            if (is_array($actualValue) === true) {
                $this->_compareArray(
                    $key,
                    $actualValue,
                    $expected,
                    $isFullSame,
                    'expected'
                );
                continue;
            }

            $this->assertSame(
                $actualValue,
                $expected[$key],
                sprintf('Values with key [%s] are not the same', $key)
            );
        }

        return $this;
    }

    /**
     * Compares key
     *
     * @param string $key           Key
     * @param array  $expectedValue Expected value
     * @param array  $actual        Actual
     * @param string $type          Type
     *
     * @return AbstractUnitTest
     */
    private function _compareKey($key, $expectedValue, $actual, $type)
    {
        if (is_string($key) === true) {
            $this->assertArrayHasKey(
                $key,
                $actual,
                sprintf(
                    'Unable to find key [%s] in [%s] array with keys [%s]',
                    $key,
                    $type,
                    implode(', ', array_keys($actual))
                )
            );

            return $this;
        }

        if (is_array($expectedValue) === true) {
            $this->compareExpectedAndActual($expectedValue, $actual[$key]);
            return $this;
        }

        $this->assertTrue(
            in_array($expectedValue, $actual),
            sprintf(
                'Unable to find value [%s] in [%s] array with values [%s]',
                $expectedValue,
                $type,
                implode(', ', $actual)
            )
        );

        return $this;
    }

    /**
     * Compares arrays
     *
     * @param string $key           Key
     * @param array  $expectedValue Expected value
     * @param array  $actual        Actual
     * @param bool   $isFullSame    Flag of full comparing
     * @param string $type          Type
     *
     * @return void
     */
    private function _compareArray(
        $key,
        $expectedValue,
        $actual,
        $isFullSame,
        $type
    ) {
        $actualValue = $actual[$key];
        if ($actualValue instanceof AbstractModel) {
            $actualValue = $actualValue->get();
        }

        $this->assertTrue(
            is_array($actualValue),
            sprintf(
                '[%s] data with key [%s] is not an array. Array expected.',
                $type,
                $key
            )
        );

        $this->compareExpectedAndActual(
            $expectedValue,
            $actualValue,
            $isFullSame
        );
    }

    /**
     * Compares date time
     *
     * @param \DateTime $dateTime      Date time
     * @param string    $key           Key
     * @param string    $expectedValue Expected value
     *
     * @return void
     */
    private function _compareDateTime($dateTime, $key, $expectedValue)
    {
        $expectedDateTime = new \DateTime($expectedValue);
        $this->assertTrue(
            ($dateTime->getTimestamp() % $expectedDateTime->getTimestamp()) < 5,
            sprintf(
                'Values with key [%s] are not the same. ' .
                'Expected: [%s], actual: [%s]',
                $key,
                $expectedDateTime->format('Y-m-d H:i:s'),
                $dateTime->format('Y-m-d H:i:s')
            )
        );
    }

    /**
     * Generates random string
     *
     * @param string $length String length
     *
     * @return string
     */
    protected function generateStringWithLength($length)
    {
        $characters
            = '0123456789abcdefghijklmnopqrstuvwxyz' .
                'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, ($charactersLength - 1))];
        }

        return $randomString;
    }
}
