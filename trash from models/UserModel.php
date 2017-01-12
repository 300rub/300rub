<?php

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