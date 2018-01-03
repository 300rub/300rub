<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserSectionOperationModel;

use testS\models\user\UserSectionOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
