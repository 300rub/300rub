<?php

namespace ss\models\blocks\image;

use ss\application\components\db\Table;
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

    /**
     * Finds model by image instance ID
     *
     * @param int $instanceId Instance ID
     *
     * @return ImageModel
     */
    public function findByImageInstanceId($instanceId)
    {
        $this->getTable()
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'imageGroups',
                'imageGroups',
                'imageId',
                Table::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'imageInstances',
                'imageInstances',
                'imageGroupId',
                'imageGroups',
                self::PK_FIELD
            )
            ->addWhere(
                sprintf(
                    'imageInstances.%s = :instanceId',
                    self::PK_FIELD
                )
            )
            ->addParameter('instanceId', $instanceId);

        return $this->find();
    }
}
