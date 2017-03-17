<?php

namespace testS\controllers;

/**
 * PageController
 *
 * @package testS\controllers
 */
class PageController extends AbstractController
{
    
    public function getLoginPage()
    {
        ob_start();
		ob_implicit_flush(false);
        require(__DIR__ . "/../views/login.php");
		return ob_get_clean();
    }
}