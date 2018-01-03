<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserSectionGroupOperationModel;

use testS\models\user\UserSectionGroupOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserSectionGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionGroupOperationModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionGroupOperationModel
     */
    protected function getNewModel()
    {
        return new UserSectionGroupOperationModel();
    }
}
