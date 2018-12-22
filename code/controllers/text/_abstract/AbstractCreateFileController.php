<?php

namespace ss\controllers\text\_abstract;

use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\helpers\file\FileModel;

/**
 * Adds file
 */
abstract class AbstractCreateFileController extends AbstractController
{

    /**
     * Uploads file
     *
     * @return FileModel
     */
    public function upload()
    {
        $fileModel = new FileModel();
        $fileModel->parsePostRequest();
        $fileModel->setUniqueName();
        $fileModel->upload();
        $fileModel->save();

        return $fileModel;
    }
}
