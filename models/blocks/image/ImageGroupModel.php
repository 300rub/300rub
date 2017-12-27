<?php

namespace testS\models\blocks\image;

use testS\application\components\Db;
use testS\models\blocks\image\_base\AbstractImageGroupModel;

/**
 * Model for working with table "imageGroups"
 */
class ImageGroupModel extends AbstractImageGroupModel
{

    /**
     * Adds imageId condition to SQL request
     *
     * @param int $imageId Image ID
     *
     * @return ImageGroupModel
     */
    public function byImageId($imageId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.imageId = :imageId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('imageId', (int)$imageId);

        return $this;
    }
}
