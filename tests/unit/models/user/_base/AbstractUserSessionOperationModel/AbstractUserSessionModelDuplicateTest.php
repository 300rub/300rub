<?php

namespace testS\tests\unit\models\user\_base\AbstractUserSessionModel;

use testS\application\components\Operation;
use testS\models\user\UserSessionModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserSessionModel
 */
class AbstractUserSessionModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return UserSessionModel
     */
    protected function getNewModel()
    {
        return new UserSessionModel();
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'userId'       => 1,
                'token'        => $this->generateStringWithLength(32),
                'ip'           => '127.0.0.1',
                'ua'           => self::UA_FIREFOX_4_0_1,
                'lastActivity' => date('Y-m-d H:i:s')
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
