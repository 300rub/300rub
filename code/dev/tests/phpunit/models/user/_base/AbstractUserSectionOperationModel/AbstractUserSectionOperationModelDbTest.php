<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSectionOperationModel;

use ss\models\user\UserSectionOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserSectionOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSectionOperationModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionOperationModel
     */
    protected function getNewModel()
    {
        return new UserSectionOperationModel();
    }
}
