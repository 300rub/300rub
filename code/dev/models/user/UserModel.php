<?php

namespace ss\models\user;

use ss\application\components\db\Table;
use ss\models\user\_abstract\AbstractSaveOperationModel;

/**
 * Model for working with table "users"
 */
class UserModel extends AbstractSaveOperationModel
{

    /**
     * Password salt
     */
    const PASSWORD_SALT = '(^_^)';

    /**
     * Length of password
     */
    const PASSWORD_HASH_LENGTH = 40;

    /**
     * Remember or not
     *
     * @var boolean
     */
    public $isRemember = false;

    /**
     * Gets type as string
     *
     * @param int $type Type value
     *
     * @return string
     */
    public function getType($type = null)
    {
        if ($type === null) {
            $type = $this->get('type');
        }

        $typeList = $this->getTypeList(false);
        if (array_key_exists($type, $typeList) === false) {
            return null;
        }

        return $typeList[$type];
    }

    /**
     * Adds login condition to SQL request
     *
     * @param string $login Login
     *
     * @return UserModel
     */
    public function byLogin($login)
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.login = :login',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('login', $login);

        return $this;
    }

    /**
     * Adds email condition to SQL request
     *
     * @param string $email Email
     *
     * @return UserModel
     */
    public function byEmail($email)
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.email = :email',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('email', $email);

        return $this;
    }

    /**
     * Is owner
     *
     * @return bool
     */
    public function isOwner()
    {
        return $this->get('type') === self::TYPE_OWNER;
    }

    /**
     * Gets password hash
     *
     * @param string $password Password hash
     *
     * @return string
     */
    public function getPasswordHash($password)
    {
        return sha1(md5($password . self::PASSWORD_SALT));
    }

    /**
     * Gets new model
     *
     * @return UserModel
     */
    public static function model()
    {
        return new self;
    }
}
