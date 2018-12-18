<?php

namespace ss\controllers\image\_abstract;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Abstract class to create images
 */
abstract class AbstractCreateImageController extends AbstractController
{

    /**
     * Image group ID
     *
     * @var int
     */
    private $_imageGroupId = 0;

    /**
     * Image ID
     *
     * @var int
     */
    private $_imageId = 0;

    /**
     * Block ID
     *
     * @var int
     */
    private $_blockId = 0;

    /**
     * Is null group ID
     *
     * @var bool
     */
    private $_isNullGroupId = false;

    /**
     * Sets isNullGroupId to be true
     *
     * @return AbstractCreateImageController
     */
    public function markGroupIdAsNull()
    {
        $this->_isNullGroupId = true;
        return $this;
    }

    /**
     * Sets image group ID
     *
     * @param int $imageGroupId Image Group ID
     *
     * @return AbstractCreateImageController
     */
    protected function setImageGroupId($imageGroupId)
    {
        $this->_imageGroupId = (int)$imageGroupId;
        return $this;
    }

    /**
     * Sets image ID
     *
     * @param int $imageId Image ID
     *
     * @return AbstractCreateImageController
     */
    protected function setImageId($imageId)
    {
        $this->_imageId = (int)$imageId;
        return $this;
    }

    /**
     * Sets block ID
     *
     * @param int $blockId Block ID
     *
     * @return AbstractCreateImageController
     */
    protected function setBlockId($blockId)
    {
        $this->_blockId = (int)$blockId;
        return $this;
    }

    /**
     * Creates image
     *
     * @return array
     */
    protected function create()
    {
        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(
            [
                'imageGroupId' => $this->_getImageGroupId(),
            ]
        );

        return $imageInstanceModel->upload();
    }

    /**
     * Gets group ID
     *
     * @return int
     */
    private function _getImageGroupId()
    {
        if ($this->_isNullGroupId === true) {
            return null;
        }

        if ($this->_imageGroupId > 0) {
            return $this->_imageGroupId;
        }

        if ($this->_imageId === 0) {
            $blockModel = BlockModel::model()->getById($this->_blockId);
            $this->_imageId = $blockModel->get('contentId');
        }

        $imageGroupModel = ImageGroupModel::model()
            ->byImageId($this->_imageId)
            ->find();

        if ($imageGroupModel !== null) {
            return $imageGroupModel->getId();
        }

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                'imageId' => $this->_imageId,
                'seoModel' => [
                    'name'  => App::getInstance()
                        ->getLanguage()
                        ->getMessage('common', 'default'),
                    'alias' => 'default'
                ]
            ]
        );
        $imageGroupModel->save();

        return $imageGroupModel->getId();
    }
}
