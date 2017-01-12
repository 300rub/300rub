<?php

//self::FIELD_BEFORE_SAVE => [
//    "setIsMain"
//]
//
// /**
//  * Adds isMain condition in SQL request
//  *
//  * @return SectionModel
//  */
//    public function selectMain()
//{
//    $this->getDb()->addWhere(sprintf("%s.isMain = :isMain", $this->getTableName()));
//    $this->getDb()->addParameter("isMain", 1);
//    return $this;
//}
//
//    /**
//     * Sets isMain
//     *
//     * @param bool $value
//     *
//     * @return bool
//     */
//    protected function setIsMain($value)
//{
//    if ($value === true) {
//        $this->getDb()
//            ->addField("isMain")
//            ->addParameter("isMain", 0)
//            ->setWhere("id > 0")
//            ->update();
//    } elseif (!$this->selectMain()->exceptId($this->id)->find()) {
//        $value = true;
//    }
//
//    return $value;
//}

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