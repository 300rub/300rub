<?php

namespace ss\models\blocks\image;

use ss\application\components\Db;

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
        $this->getDb()->addWhere('t.imageGroupId = :imageGroupId');
        $this->getDb()->addParameter('imageGroupId', $groupId);
        $this->getDb()->setOrder('t.isCover DESC, t.sort');
        $this->getDb()->setLimit(1);

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
        $this->getDb()->addWhere('t.imageGroupId = :imageGroupId');
        $this->getDb()->addParameter('imageGroupId', $groupId);

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
        $this->getDb()->addJoin(
            Db::JOIN_TYPE_INNER,
            'imageGroups',
            'imageGroups',
            self::PK_FIELD,
            Db::DEFAULT_ALIAS,
            'imageGroupId'
        );

        $this->getDb()->addWhere(
            'imageGroups.imageId = :imageId'
        );
        $this->getDb()->addParameter('imageId', $imageId);

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
     * Runs after changing
     *
     * @return void
     */
    protected function afterChange()
    {
        parent::afterChange();

        $this->_getImageGroupModel()->resetMemcached();
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
