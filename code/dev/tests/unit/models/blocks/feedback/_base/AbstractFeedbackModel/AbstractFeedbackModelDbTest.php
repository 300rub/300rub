<?php

namespace ss\tests\unit\models\blocks\feedback\_base\AbstractFeedbackModel;

use ss\models\blocks\feedback\FeedbackModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model FeedbackModel
 */
class AbstractFeedbackModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FeedbackModel
     */
    protected function getNewModel()
    {
        return new FeedbackModel();
    }
}
