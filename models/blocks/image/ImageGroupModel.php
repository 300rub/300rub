<?php

namespace ss\models\blocks\image;

use ss\application\components\Db;
use ss\models\blocks\image\_base\AbstractImageGroupModel;

/**
 * Model for working with table "imageGroups"
 */
class ImageGroupModel extends AbstractImageGroupModel
{

    /**
     * Image instance count
     *
     * @var int
     */
    private $_count = 0;

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

    /**
     * Finds all by image ID
     *
     * @param int $imageId Image ID
     *
     * @return ImageGroupModel[]
     */
    public function findAllByImageId($imageId)
    {
        return ImageGroupModel::model()
            ->byImageId($imageId)
            ->ordered('sort')
            ->withRelations()
            ->findAll();
    }

    /**
     * Find by URL
     *
     * @param string $url URL
     *
     * @return ImageGroupModel
     */
    public function byUrl($url)
    {
        $this->getDb()->addJoin(
            'seo',
            'seo',
            Db::DEFAULT_ALIAS,
            'seoId'
        );

        $this->getDb()->addWhere(
            'seo.url = :url'
        );
        $this->getDb()->addParameter('url', $url);

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
}
