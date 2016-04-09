<?php

namespace application;
use components\Language;

/**
 * Class Test
 *
 * @package application
 */
class Test extends AbstractApplication
{

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        Language::$activeId = Language::LANGUAGE_EN_ID;
    }
}