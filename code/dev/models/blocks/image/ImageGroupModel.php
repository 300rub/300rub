<?php

namespace ss\models\blocks\image;

use ss\application\App;
use ss\application\components\Db;
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
        $this->getDb()->addJoin(
            Db::JOIN_TYPE_INNER,
            'seo',
            'seo',
            self::PK_FIELD,
            Db::DEFAULT_ALIAS,
            'seoId'
        );

        $this->getDb()->addWhere(
            'seo.alias = :alias'
        );
        $this->getDb()->addParameter('alias', $alias);

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

    /**
     * Runs after changing
     *
     * @return void
     */
    protected function afterChange()
    {
        parent::afterChange();
        $this->resetMemcached();
    }

    /**
     * Resets Memcached
     *
     * @return void
     */
    public function resetMemcached()
    {
        $imageModel = ImageModel::model()
            ->set(['id' => $this->get('imageId')]);

        $imageModel
            ->deleteHtmlMemcached(
                $imageModel->getHtmlMemcachedKey(0)
            )
            ->deleteHtmlMemcached(
                $imageModel->getHtmlMemcachedKey(-1)
            )
            ->deleteHtmlMemcached(
                $imageModel->getHtmlMemcachedKey($this->getId())
            );
    }
}
