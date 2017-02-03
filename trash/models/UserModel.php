<?php

///**
// * Salt
// */
//const SALT = "saltForUser";

//self::FIELD_BEFORE_SAVE => [
//    "setPassword"
//]


///**
// * Sets password
// *
// * @param string $value
// *
// * @return string
// */
//protected function setPassword($value)
//{
//    if (mb_strlen($value, "UTF-8") !== self::PASSWORD_HASH_LENGTH) {
//        $value = self::createPasswordHash($value);
//    }
//
//    return $value;
//}
//
///**
// * Gets password hash
// *
// * @param string $password Password
// *
// * @return string
// */
//public static function createPasswordHash($password)
//{
//    return sha1(md5($password) . self::SALT);
//}

///**
// * Finds model by login
// *
// * @param string $login Login
// *
// * @return UserModel|null
// */
//public function findByLogin($login)
//{
//    $login = trim($login);
//    if (!$login) {
//        return null;
//    }
//
//    $this->getDb()
//        ->addWhere("login = :login")
//        ->addParameter("login", $login);
//
//    return $this->find();
//}