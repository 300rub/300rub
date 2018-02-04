<?php

namespace testS\tests\selenium;

use Behat\Mink\Mink;

class Test extends  \PHPUnit_Framework_TestCase
{

//    /**
//     * Mink instance
//     *
//     * @var Mink
//     */
//    protected static $_mink;
//
////rootUrl: http://test-%s.toolkit.local
////screenshotsDirectory: /tmp/selenium
////drivers:
//    //localhost_firefox:
//        //class: EE\Library\TestBundle\Logic\ToolkitSelenium2Driver
//        //arguments:
//            //- firefox
//            //- browserName: firefox
//            //firefox_profile: ../Resources/config/localhost/firefox_profile.zip.b64
//            //- http://selenium:4444/wd/hub
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
//        $arguments = [
//            'firefox',
//            'browserName' => 'firefox',
//            'firefox_profile' => 'UEsDBBQDAAAIANFpT0OMzWDE+QMAANsJAAAIAAAAcHJlZnMuanOVVU1z2jAQvedXaNJLm4IwkABp
//p5dOp53M9GvapFfPIq3xFllypTWG/vpKhjQNCU0yMFiS9z097T4tz8Qn95uMAXEV0IuvHgv0aBWG
//o6PBiXjnhHUsUBMLLimIggzKI3ESv+KiEBvXiAqWKFQJdoFBsLuJE20Zf+McBdS1IQVMzor41jfW
//kl30EguXN+g2KhFzFG6FvvXEjDaSoL3DgWvicK3j0m01QHzYBsyOLmmpb87T68QqsGJFgbijvPr2
//UcDcNfxKOVvQIrG9d15UzqMgWzhfdfv1REAUJXP9ajBo21ZW26RJ5xeDxtJ6oJrArqLf8VSy5Mo8
//SzuHyDc4OmoC+jzNnx+DikoCzckQbyRvaoQSQRdktSwMhPIt+OOeyF68voWqa9nUGhhljOGrbnhJ
//FUrQ2tn+HNRy4V1jdX8b1uf4MhENx6fD8/PZcDZ9LOPcOLU0FPhB1vE0e7TOgOBV2Ue7IIsH6Gaj
//Pbq5d22cSQWqRKkpLOOwBhVTl1DZ6exsOnkQEirwnAf6jbIgHziP5ovwAkzAJ4DzblXnKzANdtuP
//T0enDyrewvIQzP/3rGjhO6vJaP1ALkk8cLbagMKwlfbWuWV8LsOPv6jRAdTNTYiuWUEcaBnQoGLU
//lzC/sBrX6Vz3wz0tSg5yLEPp2rQN++bAUQJHYU0tS1dhDYuUrOPtJUsrx48D5akFeNLRkA0ZffEu
//sYyy4Sg7y8bDYTbJTp/MVAV2tpPjV6+GI5kdYthY9dW7yv0gbMNHLPjulSRttiZ/B2Q2nx1TsetN
//naHH08loej6e7IEsG6lK8AG5QtvIW35JwlqyOi71h6OzUU80oQ9BEfXExfcv/dns7Lw/7Imry/f9
//2Z70ymkqNqmVoA9y28wkKKYV3u87i9w6v4yhbknYuSN86jyIelvdA4DUBCOzwpqlxgIaw0k445oH
//qfH1/mnTg3VaebneW43z17/eZPK8dzI46UazW+9/hpjF+3evvVtvpHV5GhCG3Nm0u3EKTOkCx9yP
//pjKLn5ioE+l8+iOIh5TNMs27uP9Sp5Z89xbsrpwGhjmEbeE/AVlGmy7SfsnvIksK7PxG4rqm3T3n
//qC0QWs5V4316VrDOk2PDdXebPZ3L1UwVmPxaate7Et9kOp2OhpNsj9LTCtRGqlp3Jtxzy35YAEsc
//CXftCt+vx1+Tc+51TMB4MOKNbMHbfEUYzb3IK1qj3u3yeEDXdmKxFR6A1mhMlK+W6KUmlbICfpO8
//gTb/8Hav5imBEI0RD9U0VVdOSfsN8HDodQf+ZYh3xZ+cz8an2dltbCyQDQzGyLaMkYYiFrROqo4f
//FSnHk3uCW5zrWBD00c8QU8OpFIvusE1imRtMiD9QSwECPwMUAwAACADRaU9DjM1gxPkDAADbCQAA
//CAAAAAAAAAAAACCAgIEAAAAAcHJlZnMuanNQSwUGAAAAAAEAAQA2AAAAHwQAAAAA',
//            'http://selenium:4444/wd/hub'
//        ];
//
//
//        $reflection = new \ReflectionClass('EE\Library\TestBundle\Logic\ToolkitSelenium2Driver');
//
////            foreach ($driverConfig['arguments'][1] as $key => &$value) {
////                if ($key === 'firefox_profile') {
////                    $value = file_get_contents(__DIR__ . '/'. $value);
////                }
////            }
//
//        $driver = $reflection->newInstanceArgs($arguments);
//
//        $this->getMink()->registerSession('localhost_firefox', $this->_createSession($driver));
//    }
//
//    protected function _createSession(DriverInterface $driver)
//    {
//        $session = new Session($driver);
//        $session->getSelectorsHandler()->registerSelector('named', new NamedSelector());
//        return $session;
//    }
//






    public function getUrl()
    {
        return sprintf('localhost:800%s', getenv('TEST_TOKEN') + 1);
    }

    public function testA()
    {
        $this->assertEquals(0, getenv('TEST_TOKEN'));
    }

    public function testB()
    {
        $this->assertEquals(1, getenv('TEST_TOKEN'));
    }

    public function testC()
    {
        $this->assertEquals(0, getenv('TEST_TOKEN'));
    }

    public function testD()
    {
        $this->assertEquals(1, getenv('TEST_TOKEN'));
    }
}
