<?php
//

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
// * @param integer $imageAlbumId ImageAlbum ID
// *
// * @return ImageInstanceModel
// */
//public function byAlbumId($imageAlbumId = 0)
//{
//    $this->getDb()
//        ->addWhere("imageAlbumId = :imageAlbumId")
//        ->addParameter("imageAlbumId", $imageAlbumId);
//
//    return $this;
//}