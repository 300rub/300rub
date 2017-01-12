<?php


///**
// * Adds url & language condition in SQL request
// *
// * @param string $url url раздела
// *
// * @return SectionModel
// */
//public function byUrl($url = "")
//{
//    $this->withRelations();
//
//    $this->getDb()->addWhere(sprintf("%s.language = :language", $this->getTableName()));
//    $this->getDb()->addParameter("language", Language::$activeId);
//
//    if ($url) {
//        $this->getDb()->addWhere("seoModel.url = :url");
//        $this->getDb()->addParameter("url", $url);
//    } else {
//        $this->selectMain();
//    }
//
//    return $this;
//}

///**
// * Gets width
// *
// * @return string
// */
//public function getWidth()
//{
//    if ($this->width <= 100) {
//        return sprintf("%s%", $this->width);
//    }
//
//    return sprintf("%spx", $this->width);
//}