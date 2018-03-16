<?php

namespace ss\models\blocks\image;

use ss\application\App;
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

    /**
     * Runs before deleting
     *
     * @return void
     */
    protected function beforeDelete()
    {
        $this->resetMemcached();

        $imageInstances = ImageInstanceModel::model()
            ->byGroupId($this->getId())
            ->withRelations()
            ->findAll();

        foreach ($imageInstances as $imageInstance) {
            $imageInstance->delete();
        }

        parent::beforeDelete();
    }

    /**
     * Runs before saving
     *
     * @return void
     */
    protected function beforeSave()
    {
        $this->resetMemcached();

        parent::beforeSave();
    }

    /**
     * Resets Memcached
     *
     * @return void
     */
    public function resetMemcached()
    {
        $memcached = App::getInstance()->getMemcached();
        $memcached->delete(
            sprintf(
                ImageModel::CACHE_KEY_MASK,
                $this->get('imageId'),
                ''
            )
        );

        $seoModel = $this->getRelationModelByFieldName('seoId', true);

        $memcached->delete(
            sprintf(
                ImageModel::CACHE_KEY_MASK,
                $this->get('imageId'),
                $seoModel->get('url')
            )
        );
    }
}
