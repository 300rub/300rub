<?php

namespace testS\tests\unit\models;

use testS\models\FeedbackModel;

/**
 * Tests for the model FeedbackModel
 *
 * @package testS\tests\unit\models
 */
class FeedbackModelTest extends AbstractModelTest
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