<?php
//

///**
// * Format of file
// *
// * @var string
// */
//private $_format = "jpg";

//self::FIELD_BEFORE_SAVE => [
//    "setFileName"
//],

///**
// * Sets file name
// *
// * @param string $value
// *
// * @return string
// */
//protected function setFileName($value)
//{
//    if (!$this->id && $this->_format) {
//        return substr(md5(time()), 0, self::FILE_NAME_LENGTH) . "." . $this->_format;
//    }
//
//    return $value;
//}

//
///**
// * Runs before deleting
// */
//protected function beforeDelete()
//{
//    //		$file = new File($this->fileName);
//    //		$fileView = new File(self::VIEW_PREFIX . $this->fileName);
//    //		$fileThumb = new File(self::THUMB_PREFIX . $this->fileName);
//    //
//    //		$file->delete();
//    //		$fileView->delete();
//    //		$fileThumb->delete();
//
//    parent::beforeDelete();
//}
//
///**
// * Add condition for select by image ID
// *
// * @param integer $imageGroupId ImageAlbum ID
// *
// * @return ImageInstanceModel
// */
//public function byAlbumId($imageGroupId = 0)
//{
//    $this->getDb()
//        ->addWhere("imageGroupId = :imageGroupId")
//        ->addParameter("imageGroupId", $imageGroupId);
//
//    return $this;
//}