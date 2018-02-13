<?php

namespace ss\tests\unit\models\user\_base\AbstractUserSessionModel;

use ss\models\user\UserSessionModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserSessionModel
 */
class AbstractUserSessionModelDbTest extends AbstractDbModelTest
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
}
