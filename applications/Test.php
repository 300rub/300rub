<?php

namespace testS\applications;

use testS\components\Language;

/**
 * Class Test
 *
 * @package testS\application
 */
class Test extends AbstractApplication
{

    /**
     * Runs application
     */
    public function run()
    {
        Language::setActiveId(Language::LANGUAGE_EN_ID);
    }
}