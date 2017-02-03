<?php

//* @property int $sort
//* @property int $sectionId
//*
// * @method GridLineModel[] findAll()
//* @method GridLineModel   byId($id)
//* @method GridLineModel   find()
//* @method GridLineModel   withRelations()
//* @method GridLineModel   ordered($value)

///**
// * Adds section ID to SQL request
// *
// * @param int $sectionId Section ID
// *
// * @return GridLineModel
// */
//public function bySectionId($sectionId = null)
//{
//    if ($sectionId) {
//        $this->getDb()
//            ->addWhere("sectionId = :sectionId")
//            ->addParameter("sectionId", $sectionId);
//    }
//
//    return $this;
//}