<?php

///**
// * Gets CSS text-align value
// *
// * @return string
// */
//public function getTextAlign()
//{
//    if (array_key_exists($this->align, self::$textAlignList)) {
//        return self::$textAlignList[$this->align];
//    }
//
//    return "";
//}
//
///**
// * Gets CSS text-decoration value
// *
// * @return string
// */
//public function getTextDecoration()
//{
//    if (array_key_exists($this->decoration, self::$textDecorationList)) {
//        return self::$textDecorationList[$this->decoration];
//    }
//
//    return self::$textDecorationList[self::TEXT_DECORATION_NONE];
//}
//
///**
// * Gets CSS text-transform value
// *
// * @return string
// */
//public function getTextTransform()
//{
//    if (array_key_exists($this->transform, self::$textTransformList)) {
//        return self::$textTransformList[$this->transform];
//    }
//
//    return self::$textTransformList[self::TEXT_TRANSFORM_NONE];
//}
//
///**
// * Gets CSS font-family value
// *
// * @return string
// */
//public function getFontFamilyClass()
//{
//    if ($this->family !== self::FAMILY_MYRAD
//        && array_key_exists($this->family, self::$familyList)
//    ) {
//        return self::$familyList[$this->family]["class"];
//    }
//
//    return "";
//}