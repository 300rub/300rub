<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\image\ImageModel;

/**
 * Gets block's content
 */
class GetContentController extends AbstractController
{

    /**
     * Block model
     *
     * @var BlockModel
     */
    private $_blockModel = null;

    /**
     * Image model
     *
     * @var ImageModel
     */
    private $_imageModel = null;

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function run()
    {
        $this->checkData(
            [
                'id' => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('id'),
            Operation::IMAGE_UPDATE_CONTENT
        );

        $this->_blockModel = BlockModel::model()
            ->getById($this->get('id'));

        $this->_imageModel = $this->_blockModel
            ->getContentModel(ImageModel::CLASS_NAME);

        $groupId = (int)$this->get('groupId');
        if ($this->_imageModel->get('useAlbums') === true
            && $groupId === 0
        ) {
            return [
                'id'     => $this->_blockModel->getId(),
                'labels' => [],
                'name'   => $this->_blockModel->get('name'),
                'button' => [
                    'label' => App::getInstance()
                        ->getLanguage()
                        ->getMessage('common', 'save')
                ],
                'useAlbums'      => true,
                'canCreate' => $this->hasBlockOperation(
                    BlockModel::TYPE_IMAGE,
                    $this->get('id'),
                    Operation::IMAGE_CREATE_ALBUM
                ),
                'canUpdate' => $this->hasBlockOperation(
                    BlockModel::TYPE_IMAGE,
                    $this->get('id'),
                    Operation::IMAGE_UPDATE_ALBUM
                ),
                'canDelete' => $this->hasBlockOperation(
                    BlockModel::TYPE_IMAGE,
                    $this->get('id'),
                    Operation::IMAGE_DELETE_ALBUM
                ),
                'list'
                    => $this->_getListWithAlbums()
            ];
        }

        return $this->_getImagesResponse();
    }

    /**
     * Gets images response
     *
     * @return array
     */
    private function _getImagesResponse()
    {
        $language = App::getInstance()->getLanguage();

        return [
            'id'        => $this->_blockModel->getId(),
            'labels'    => [
                'deleteConfirm'
                    => $language->getMessage('image', 'imageDeleteConfirm'),
                'delete'
                    => $language->getMessage('common', 'delete'),
                'no'
                    => $language->getMessage('common', 'no'),
            ],
            'name'      => $this->_blockModel->get('name'),
            'button'    => [
                'label' => App::getInstance()
                    ->getLanguage()
                    ->getMessage('common', 'save')
            ],
            'useAlbums' => false,
            'groupId'   => (int)$this->get('groupId'),
            'canCreate' => $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $this->get('id'),
                Operation::IMAGE_UPLOAD
            ),
            'canUpdate' => $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $this->get('id'),
                Operation::IMAGE_UPDATE
            ),
            'canDelete' => $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $this->get('id'),
                Operation::IMAGE_DELETE
            ),
            'list'      => $this->_getListWithoutAlbums()
        ];
    }

    /**
     * Gets list with albums
     *
     * @return array
     */
    private function _getListWithAlbums()
    {
        $list = [];

        $imageGroupModels = ImageGroupModel::model()
            ->byImageId($this->_imageModel->getId())
            ->ordered('sort')
            ->findAll();
        foreach ($imageGroupModels as $imageGroupModel) {
            $cover = ImageInstanceModel::model()
                ->coverByGroupId($imageGroupModel->getId())
                ->find();
            if ($cover !== null) {
                $cover = [
                    'id'  => $cover->getId(),
                    'url' => $cover->get('thumbFileModel')->getUrl(),
                    'alt' => $cover->get('alt'),
                ];
            }

            $list[] = [
                'id'    => $imageGroupModel->getId(),
                'name'  => $imageGroupModel->get('seoModel')->get('name'),
                'cover' => $cover
            ];
        }

        return $list;
    }

    /**
     * Gets list without albums
     *
     * @return array
     */
    private function _getListWithoutAlbums()
    {
        $list = [];

        $imageInstanceModels = $this->_getImageInstanceModels(
            $this->_imageModel->get('useAlbums'),
            $this->_imageModel->getId()
        );

        foreach ($imageInstanceModels as $imageInstanceModel) {
            $list[] = [
                'id'   => $imageInstanceModel->getId(),
                'name' => $imageInstanceModel->get('alt'),
                'url'  => $imageInstanceModel->get('thumbFileModel')->getUrl()
            ];
        }

        return $list;
    }

    /**
     * Gets image instance models
     *
     * @param bool    $useAlbums Flag of using albums
     * @param integer $imageId   Image ID
     *
     * @return AbstractModel[]|ImageInstanceModel[]
     */
    private function _getImageInstanceModels($useAlbums, $imageId)
    {
        $groupId = (int)$this->get('groupId');

        if ($useAlbums === true
            && $groupId > 0
        ) {
            return ImageInstanceModel::model()
                ->byGroupId($groupId)
                ->ordered('sort')
                ->findAll();
        }

        return ImageInstanceModel::model()
            ->byImageId($imageId)
            ->ordered('sort')
            ->findAll();
    }
}
