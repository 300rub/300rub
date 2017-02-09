<?php

namespace testS\components;

/**
 * Class for work with user from session
 *
 * @package testS\components
 */
class User
{

    /**
     * User Life Time
     */
    const USER_LIFE_TIME = 1800;

    /**
     * Session ID
     *
     * @var string
     */
	private $sid = "";

    /**
     * Operations
     *
     * @var array
     */
    private $operations = [];

    /**
     * ID
     *
     * @var int
     */
    private $id = 0;

    /**
     * Login
     *
     * @var string
     */
    private $login = "";

    /**
     * Name
     *
     * @var string
     */
    private $name = "";

    /**
     * Email
     *
     * @var string
     */
    private $email = "";

    /**
     * Admin flag
     *
     * @var bool
     */
    private $isAdmin = false;

    /**
     * Gets Session ID
     *
     * @return string
     */
    public function getSid()
    {
        return $this->sid;
    }

    // @TODO constructor & get & set methods
}