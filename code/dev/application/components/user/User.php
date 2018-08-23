<?php

namespace ss\application\components\user;

use ss\models\user\UserModel;

/**
 * Class for work with user from session
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
     * Operations
     *
     * @var array
     */
    private $_operations = [];

    /**
     * ID
     *
     * @var integer
     */
    private $_id = 0;

    /**
     * Login
     *
     * @var string
     */
    private $_login = '';

    /**
     * Name
     *
     * @var string
     */
    private $_name = '';

    /**
     * Email
     *
     * @var string
     */
    private $_email = '';

    /**
     * Type
     *
     * @var integer
     */
    private $_type = '';

    /**
     * User constructor.
     *
     * @param string    $token     Token key
     * @param UserModel $userModel User model
     */
    public function __construct($token, UserModel $userModel)
    {
        $this->_token = $token;
        $this->_operations = $userModel->getOperations();
        $this->_id = $userModel->getId();
        $this->_login = $userModel->get('login');
        $this->_name = $userModel->get('name');
        $this->_email = $userModel->get('email');
        $this->_type = $userModel->get('type');
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

    /**
     * Gets is owner
     *
     * @return int
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Is owner flag
     *
     * @return bool
     */
    public function isOwner()
    {
        return $this->getType() === UserModel::TYPE_OWNER;
    }
}
