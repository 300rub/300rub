<?php

namespace ss\models\blocks\image;

use ss\models\blocks\image\_content\AbstractContentImageModel;

/**
 * Model for working with table "images"
 */
class ImageModel extends AbstractContentImageModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\image\\ImageModel';

    /**
     * Gets ImageModel
     *
     * @return ImageModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Runs before deleting
     *
     * @return void
     */
    protected function beforeDelete()
    {
        $imageGroups = ImageGroupModel::model()->findAllByImageId(
            $this->getId()
        );
        foreach ($imageGroups as $imageGroup) {
            $imageGroup->delete();
        }

        parent::beforeDelete();
    }
}
