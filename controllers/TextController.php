<?php

namespace testS\controllers;

use testS\applications\App;

/**
 * Text's controller
 *
 * @package testS\controllers
 */
class TextController extends AbstractController
{

    public function getBlock()
    {
        $memcached = App::getInstance()->getMemcached();
        return $memcached->get("aaa");
    }
}