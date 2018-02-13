<?php

namespace ss\tests\unit\controllers\user;

use ss\models\user\UserSessionModel;
use ss\tests\unit\controllers\_abstract\AbstractControllerTest;

/**
 * Tests for the controller GetSessionsController
 */
class GetSessionsControllerTest extends AbstractControllerTest
{

    /**
     * Test
     *
     * @return void
     */
    public function testRun()
    {
        // Add new session for user 1.
        $newToken = $this->generateStringWithLength(32);
        $newUserSessionModel = new UserSessionModel();
        $newUserSessionModel->set(
            [
                'userId' => 1,
                'token'  => $newToken,
                'ip'     => '127.0.0.7',
                'ua'     => '',
            ]
        );
        $newUserSessionModel->save();

        // Send request.
        $this->sendRequest('user', 'sessions', ['id' => 1]);
        $actualBody = $this->getBody();

        // Make sure that records for User 1 only returned.
        $userSessionModels = new UserSessionModel();
        $countSessionModels = $userSessionModels->getCount();
        $this->assertTrue(
            ($countSessionModels - count($actualBody['list'])) > 0
        );

        // Check response content.
        foreach ($actualBody['list'] as $result) {
            switch ($result['token']) {
                case self::TOKEN_OWNER:
                    $expectedResult = [
                        'ip'        => '127.0.0.1',
                        'platform'  => 'Windows',
                        'browser'   => 'Firefox',
                        'version'   => '4.0.1',
                        'isCurrent' => true,
                        'isOnline'  => true
                    ];
                    $this->compareExpectedAndActual(
                        $expectedResult,
                        $result
                    );
                    break;
                case $newToken:
                    $expectedResult = [
                        'ip'        => '127.0.0.7',
                        'platform'  => null,
                        'browser'   => null,
                        'version'   => null,
                        'isCurrent' => false,
                        'isOnline'  => true
                    ];
                    $this->compareExpectedAndActual(
                        $expectedResult,
                        $result
                    );
            }
        }

        // Remove test session.
        $newUserSessionModel->delete();
    }
}
