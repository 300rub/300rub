<?php

namespace ss\models\user;

use ss\application\components\Db;
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
        $this->getDb()->addWhere(
            sprintf(
                '%s.login = :login',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('login', $login);

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
     * @param string $password   Password hash
     * @param bool   $isOriginal Flag of original password
     *
     * @return string
     */
    public function getPasswordHash($password, $isOriginal)
    {
        if ($isOriginal === true) {
            return sha1(md5($password . self::PASSWORD_SALT));
        }

        return sha1($password);
    }
}
