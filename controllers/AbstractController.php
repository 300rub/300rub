<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\User;

/**
 * Abstract class for working with controllers
 *
 * @package testS\controllers
 */
abstract class AbstractController
{

    /**
     * Request data
     *
     * @var array
     */
    private $_data = [];

    /**
     * Gets data
     *
     * @return array
     */
    protected function getData()
    {
        return $this->_data;
    }

    /**
     * Sets data
     *
     * @param array $data
     *
     * @return AbstractController
     */
    public function setData(array $data)
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * Checks operation
     *
     * @param string $operation
     */
    protected function checkOperation($operation)
    {
        // @TODO
    }

    /**
     * Checks User
     *
     * @throws AccessException
     *
     * @return AbstractController
     */
    protected function checkUser()
    {
        if (!App::web()->getUser() instanceof User) {
            throw new AccessException("Unable to get User");
        }

        return $this;
    }
}