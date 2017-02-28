<?php

namespace testS\components;

use testS\models\UserModel;

/**
 * Class for work with user from session
 *
 * @package testS\components
 */
class User
{

    /**
     * Token
     *
     * @var string
     */
    private $_token;

    /**
     * Type
     *
     * @var int
     */
    private $_type;

    /**
     * Operations
     *
     * @var array
     */
    private $_operations = [];

    /**
     * ID
     *
     * @var int
     */
    private $_id = 0;

    /**
     * Login
     *
     * @var string
     */
    private $_login = "";

    /**
     * Name
     *
     * @var string
     */
    private $_name = "";

    /**
     * Email
     *
     * @var string
     */
    private $_email = "";

    /**
     * User constructor.
     *
     * @param string    $token
     * @param UserModel $userModel
     */
    public function __construct($token, UserModel $userModel)
    {
        $this->_token = $token;
        $this->_type = $userModel->get("type");
        $this->_operations = $userModel->getOperations();
        $this->_id = $userModel->getId();
        $this->_login = $userModel->get("login");
        $this->_name = $userModel->get("name");
        $this->_email = $userModel->get("email");
    }

    /**
     * Gets token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Gets type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Gets Operations
     *
     * @return array
     */
    public function getOperations()
    {
        return $this->_operations;
    }

    /**
     * Gets ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Gets login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->_login;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
}