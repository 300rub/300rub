<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSectionGroupOperationModel;

use ss\models\user\UserSectionGroupOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
