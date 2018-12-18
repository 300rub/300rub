<?php

namespace ss\models\blocks\block\_abstract;

use ss\models\blocks\block\_abstract\AbstractDesignBlockCssModel as Css;
use ss\models\blocks\block\DesignBlockModel;

/**
 * Model for working with table "designBlocks"
 */
abstract class AbstractDesignBlockImageModel extends Css
{

    /**
     * ID
     *
     * @var int
     */
    private $_id = null;

    /**
     * URL
     *
     * @var string
     */
    private $_url = '';

    /**
     * Create group
     *
     * @var string
     */
    private $_createGroup = '';

    /**
     * Create controller
     *
     * @var string
     */
    private $_createController = '';

    /**
     * Edit group
     *
     * @var string
     */
    private $_editGroup = '';

    /**
     * Edit controller
     *
     * @var string
     */
    private $_editController = '';

    /**
     * Crop group
     *
     * @var string
     */
    private $_cropGroup = '';

    /**
     * Crop controller
     *
     * @var string
     */
    private $_cropController = '';

    /**
     * Remove group
     *
     * @var string
     */
    private $_removeGroup = '';

    /**
     * Remove controller
     *
     * @var string
     */
    private $_removeController = '';

    /**
     * Sets ID
     *
     * @param int $imageInstanceId ID
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setId($imageInstanceId)
    {
        $this->_id = $imageInstanceId;
        return $this;
    }

    /**
     * Sets URL
     *
     * @param string $url URL
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * Sets create group
     *
     * @param string $createGroup Create group
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setCreateGroup($createGroup)
    {
        $this->_createGroup = $createGroup;
        return $this;
    }

    /**
     * Sets Create controller
     *
     * @param string $createController Create controller
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setCreateController($createController)
    {
        $this->_createController = $createController;
        return $this;
    }

    /**
     * Sets Edit group
     *
     * @param string $editGroup Edit group
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setEditGroup($editGroup)
    {
        $this->_editGroup = $editGroup;
        return $this;
    }

    /**
     * Sets Edit controller
     *
     * @param string $editController Edit controller
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setEditController($editController)
    {
        $this->_editController = $editController;
        return $this;
    }

    /**
     * Sets Crop group
     *
     * @param string $cropGroup Crop group
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setCropGroup($cropGroup)
    {
        $this->_cropGroup = $cropGroup;
        return $this;
    }

    /**
     * Sets Crop controller
     *
     * @param string $cropController Crop controller
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setCropController($cropController)
    {
        $this->_cropController = $cropController;
        return $this;
    }

    /**
     * Sets Remove group
     *
     * @param string $removeGroup Remove group
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setRemoveGroup($removeGroup)
    {
        $this->_removeGroup = $removeGroup;
        return $this;
    }

    /**
     * Sets Remove controller
     *
     * @param string $removeController Remove controller
     *
     * @return AbstractDesignBlockImageModel|DesignBlockModel
     */
    public function setRemoveController($removeController)
    {
        $this->_removeController = $removeController;
        return $this;
    }

    /**
     * Gets image options
     *
     * @return array
     */
    protected function getImageOptions()
    {
        return [
            'id'     => $this->_id,
            'url'    => $this->_url,
            'create' => [
                'group'      => $this->_createGroup,
                'controller' => $this->_createController,
            ],
            'edit'   => [
                'group'      => $this->_editGroup,
                'controller' => $this->_editController,
            ],
            'crop'   => [
                'group'      => $this->_cropGroup,
                'controller' => $this->_cropController,
            ],
            'remove' => [
                'group'      => $this->_removeGroup,
                'controller' => $this->_removeController,
            ]
        ];
    }
}
