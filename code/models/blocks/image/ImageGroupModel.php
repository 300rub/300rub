<?php

namespace ss\models\blocks\image;

use ss\application\components\db\Table;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\image\_base\AbstractImageGroupModel;

/**
 * Model for working with table "imageGroups"
 */
class ImageGroupModel extends AbstractImageGroupModel
{

    /**
     * Image instance count
     *
     * @var integer
     */
    private $_count = 0;

    /**
     * Cover
     *
     * @var ImageInstanceModel
     */
    private $_cover = null;

    /**
     * Adds imageId condition to SQL request
     *
     * @param int $imageId Image ID
     *
     * @return ImageGroupModel
     */
    public function byImageId($imageId)
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.imageId = :imageId',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('imageId', (int)$imageId);

        return $this;
    }

    /**
     * Finds all by image ID
     *
     * @param int $imageId Image ID
     *
     * @return ImageGroupModel[]
     */
    public function findAllByImageId($imageId)
    {
        return self::model()
            ->byImageId($imageId)
            ->ordered('sort')
            ->findAll();
    }

    /**
     * Find by alias
     *
     * @param string $alias Alias
     *
     * @return ImageGroupModel
     */
    public function byAlias($alias)
    {
        $this->getTable()->addJoin(
            Table::JOIN_TYPE_INNER,
            'seo',
            'seo',
            self::PK_FIELD,
            Table::DEFAULT_ALIAS,
            'seoId'
        );

        $this->getTable()->addWhere(
            'seo.alias = :alias'
        );
        $this->getTable()->addParameter('alias', $alias);

        return $this;
    }

    /**
     * Gets ImageGroupModel
     *
     * @return ImageGroupModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Sets count
     *
     * @param int $count Count
     *
     * @return ImageGroupModel
     */
    public function setCount($count)
    {
        $this->_count = $count;
        return $this;
    }

    /**
     * Gets count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * Sets count
     *
     * @param ImageInstanceModel|AbstractModel $cover Cover
     *
     * @return ImageGroupModel
     */
    public function setCover($cover)
    {
        $this->_cover = $cover;
        return $this;
    }

    /**
     * Gets cover
     *
     * @return ImageInstanceModel
     */
    public function getCover()
    {
        return $this->_cover;
    }

    /**
     * Runs before deleting
     *
     * @return void
     */
    protected function beforeDelete()
    {
        $imageInstances = ImageInstanceModel::model()
            ->byGroupId($this->getId())
            ->findAll();

        foreach ($imageInstances as $imageInstance) {
            $imageInstance->delete();
        }

        parent::beforeDelete();
    }
}
