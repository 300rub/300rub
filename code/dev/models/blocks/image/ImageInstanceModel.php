<?php

namespace ss\models\blocks\image;

use ss\application\components\db\Table;
use ss\models\blocks\image\_abstract\AbstractUpdateModel;

/**
 * Model for working with table "imageInstances"
 */
class ImageInstanceModel extends AbstractUpdateModel
{

    /**
     * Adds SQL condition to select cover
     *
     * @param int $groupId Group ID
     *
     * @return ImageInstanceModel
     */
    public function coverByGroupId($groupId)
    {
        $this->getTable()
            ->addWhere('t.imageGroupId = :imageGroupId')
            ->addParameter('imageGroupId', $groupId)
            ->setOrder('t.isCover DESC, t.sort')
            ->setLimit(1);

        return $this;
    }

    /**
     * Adds SQL condition by group ID
     *
     * @param int $groupId Group ID
     *
     * @return ImageInstanceModel
     */
    public function byGroupId($groupId)
    {
        $this->getTable()
            ->addWhere('t.imageGroupId = :imageGroupId')
            ->addParameter('imageGroupId', $groupId);

        return $this;
    }

    /**
     * Adds SQL condition by image ID
     *
     * @param int $imageId Image ID
     *
     * @return ImageInstanceModel
     */
    public function byImageId($imageId)
    {
        $this->getTable()->addJoin(
            Table::JOIN_TYPE_INNER,
            'imageGroups',
            'imageGroups',
            self::PK_FIELD,
            Table::DEFAULT_ALIAS,
            'imageGroupId'
        );

        $this->getTable()->addWhere(
            'imageGroups.imageId = :imageId'
        );
        $this->getTable()->addParameter('imageId', $imageId);

        return $this;
    }

    /**
     * Gets ImageInstanceModel
     *
     * @return ImageInstanceModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets ImageGroupModel
     *
     * @return ImageGroupModel
     */
    private function _getImageGroupModel()
    {
        return ImageGroupModel::model()
            ->byId($this->get('imageGroupId'))
            ->find();
    }
}
