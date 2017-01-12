<?php

///**
// * Adds condition to SQL
// *
// * @param string $language Language
// * @param string $category Category
// * @param string $name     Name
// *
// * @return HelpModel
// */
//public function setParams($language, $category, $name)
//{
//    $this->getDb()
//        ->addWhere("language = :language")
//        ->addParameter("language", $language)
//        ->addWhere("category = :category")
//        ->addParameter("category", $category)
//        ->addWhere("name = :name")
//        ->addParameter("name", $name);
//
//    return $this;
//}