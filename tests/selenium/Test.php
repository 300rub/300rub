<?php

namespace testS\tests\selenium;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

//require 'Session.php';
//
//use Behat\Mink\Mink;
//use Behat\Mink\Selector\NamedSelector;

class Test extends  \PHPUnit_Framework_TestCase
{
//
//    /**
//     * Mink instance
//     *
//     * @var Mink
//     */
//    protected static $_mink;
//
//    /**
//     * Options storage
//     *
//     * @var string[]
//     */
//    protected static $_options;
//
//    public static function setUpBeforeClass()
//    {
//        if (file_exists('/tmp/selenium') === false) {
//            mkdir('/tmp/selenium', 0777);
//        }
//
//        if (null === self::$_options) {
//            self::$_options = [
//                'rootUrl' => 'http://localhost:800%s',
//                'screenshotsDirectory' => '/tmp/selenium',
//                'drivers' => [
//                    'localhost_firefox' => [
//                        'class' => 'Behat\Mink\Driver\Selenium2Driver',
//                        'arguments' => [
//                            1 => [
//                                'firefox',
//                                'browserName' => 'firefox',
//                                'firefox_profile' => 'firefox_profile.zip.b64',
//                                'http://selenium:4444/wd/hub'
//                            ]
//                        ]
//                    ]
//                ]
//            ];
//        }
//    }
//
//    public static function tearDownAfterClass()
//    {
//        if (null !== self::$_mink) {
//            self::$_mink->stopSessions();
//        }
//    }
//
//    public function getMink()
//    {
//        if (null === self::$_mink) {
//            self::$_mink = new Mink();
//
//            $this->_registerSessions();
//        }
//        return self::$_mink;
//    }
//
//    protected function _registerSessions()
//    {
//        foreach ($this->_getOption('drivers') as $id => $driverConfig) {
//            $reflection = new \ReflectionClass($driverConfig['class']);
//
//            foreach ($driverConfig['arguments'][1] as $key => &$value) {
//                if ($key === 'firefox_profile') {
//                    $value = file_get_contents(__DIR__ . '/'. $value);
//                }
//            }
//
//            $driver = $reflection->newInstanceArgs($driverConfig['arguments']);
//
//            $this->getMink()->registerSession($id, $this->_createSession($driver));
//        }
//    }
//
//    /**
//     * @return string|array
//     */
//    protected function _getOption($key, $default = null)
//    {
//        return array_key_exists($key, self::$_options) ? self::$_options[$key] : $default;
//    }
//
//    protected function _createSession($driver)
//    {
//        $session = new Session($driver);
//        $session->getSelectorsHandler()->registerSelector('named', new NamedSelector());
//        return $session;
//    }
//
//    public function getRootUrl()
//    {
//        return sprintf($this->_getOption('rootUrl'), getenv('TEST_TOKEN') + 1);
//    }
//
//    protected function getSession($name = null)
//    {
//        return $this->getMink()->getSession($name);
//    }
//
//    protected function preDispatchRunTest()
//    {
//        $session = $this->getSession();
//        //$session->visit($this->getRootUrl());
//        $session->visit("https://www.google.co.uk");
//
//        $session->getDriver()->resizeWindow(1280, 1024);
//    }
//
//    protected function postDispatchRunTest()
//    {
//    }
//
//    protected function runTest()
//    {
//        foreach (array_keys($this->_getOption('drivers')) as $sessionName) {
//            $this->getMink()->setDefaultSessionName($sessionName);
//
//            try {
//                $this->preDispatchRunTest();
//                parent::runTest();
//                $this->postDispatchRunTest();
//            } catch (\Exception $ex) {
////                var_dump($ex->getMessage());
////                var_dump($ex->getFile());
////                var_dump($ex->getLine());
////                var_dump($ex->getTraceAsString());
//
//
//                if (
//                    null !== ($screenshotsDirectory = $this->_getOption('screenshotsDirectory')) &&
//                    $this->getMink()->getSession()->getDriver() instanceof \Behat\Mink\Driver\Selenium2Driver
//                ) {
//                    $imageData = $this->getSession()->getDriver()->getScreenshot();
//                    $fileName = $screenshotsDirectory . DIRECTORY_SEPARATOR .
//                        $sessionName . '_' .
//                        str_replace('\\', '-', $this->toString()) .
//                        '-' . date('c') . '.png';
//                    file_put_contents($fileName, $imageData);
//                }
//                throw $ex;
//            }
//        }
//    }
//
//    public function toString()
//    {
//        return str_replace(parent::getDataSetAsString(), '', parent::toString());
//    }
//








    public function testA()
    {
        sleep(2);
        $web_driver = RemoteWebDriver::create(
            "http://selenium:4444/wd/hub",
            array("platform"=>"WINDOWS", "browserName"=>"firefox", "version" => "latest"), 120000
        );
        $web_driver->get("http://google.com");

        $element = $web_driver->findElement(WebDriverBy::name("q"));
        if($element) {
            $element->sendKeys("TestingBot");
            $element->submit();
        }
        sleep(2);
        print $web_driver->getTitle();
        $this->assertEquals("asd", $web_driver->getTitle());
        $web_driver->quit();

//        sleep(3);
//        $this->assertPageContainsText($this->getSession(), "aaa");
//        $this->assertEquals(0, getenv('TEST_TOKEN'));
    }

//    public function testB()
//    {
//        sleep(3);
//        $this->assertEquals(1, getenv('TEST_TOKEN'));
//    }
//
//    public function testC()
//    {
//        sleep(3);
//        $this->assertEquals(0, getenv('TEST_TOKEN'));
//    }
//
//    public function testD()
//    {
//        sleep(3);
//        $this->assertEquals(1, getenv('TEST_TOKEN'));
//    }

//    protected function assertPageContainsText($subject, $text, $message = null)
//    {
//        $page = $subject->getPage()->getText();
//
//        if (null === $message) {
//            $message = sprintf('The text "%s" was not found anywhere in the text of the page', $text);
//        }
//
//        $constraint = new \PHPUnit_Framework_Constraint_StringContains($text, true);
//        $this->assertThat($page, $constraint, $message);
//    }
}
