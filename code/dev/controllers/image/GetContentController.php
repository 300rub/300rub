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

        $blockModel =  $imageModel = BlockModel::model()
            ->getById($this->get('id'));

        $imageModel = $blockModel
            ->getContentModel(ImageModel::CLASS_NAME);

        $groupId = (int)$this->get('groupId');
        $data = [
            'id'     => $blockModel->getId(),
            'labels' => [],
            'name'   => $blockModel->get('name'),
            'button' => [
                'label' => App::getInstance()
                    ->getLanguage()
                    ->getMessage('common', 'save')
            ]
        ];

        if ($imageModel->get('useAlbums') === true
            && $groupId === 0
        ) {
            return array_merge(
                $data,
                [
                    'useAlbums'      => true,
                    'canCreateAlbum' => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get('id'),
                        Operation::IMAGE_CREATE_ALBUM
                    ),
                    'canUpdateAlbum' => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get('id'),
                        Operation::IMAGE_UPDATE_ALBUM
                    ),
                    'canDeleteAlbum' => $this->hasBlockOperation(
                        BlockModel::TYPE_IMAGE,
                        $this->get('id'),
                        Operation::IMAGE_DELETE_ALBUM
                    ),
                    'list'
                        => $this->_getListWithAlbums($imageModel)
                ]
            );
        }

        return array_merge(
            $data,
            [
                'useAlbums'      => false,
                'canUploadImage' => $this->hasBlockOperation(
                    BlockModel::TYPE_IMAGE,
                    $this->get('id'),
                    Operation::IMAGE_UPLOAD
                ),
                'canUpdateImage' => $this->hasBlockOperation(
                    BlockModel::TYPE_IMAGE,
                    $this->get('id'),
                    Operation::IMAGE_UPDATE
                ),
                'canDeleteImage' => $this->hasBlockOperation(
                    BlockModel::TYPE_IMAGE,
                    $this->get('id'),
                    Operation::IMAGE_DELETE
                ),
                'list'
                    => $this->_getListWithoutAlbums($imageModel, $groupId)
            ]
        );
    }

    /**
     * Gets list with albums
     *
     * @param ImageModel|AbstractModel $imageModel Image model
     *
     * @return array
     */
    private function _getListWithAlbums($imageModel)
    {
        $list = [];

        $imageGroupModels = ImageGroupModel::model()
            ->byImageId($imageModel->getId())
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
     * @param ImageModel|AbstractModel $imageModel Image model
     * @param integer                  $groupId    Group ID
     *
     * @return array
     */
    private function _getListWithoutAlbums($imageModel, $groupId)
    {
        $list = [];

        $imageInstanceModels = $this->_getImageInstanceModels(
            $imageModel->get('useAlbums'),
            $groupId,
            $imageModel->getId()
        );

        foreach ($imageInstanceModels as $imageInstanceModel) {
            $list[] = [
                'id'  => $imageInstanceModel->getId(),
                'alt' => $imageInstanceModel->get('alt'),
                'url' => $imageInstanceModel->get('thumbFileModel')->getUrl()
            ];
        }

        return $list;
    }

    /**
     * Gets image instance models
     *
     * @param bool    $useAlbums Flag of using albums
     * @param integer $groupId   Group ID
     * @param integer $imageId   Image ID
     *
     * @return AbstractModel[]|ImageInstanceModel[]
     */
    private function _getImageInstanceModels($useAlbums, $groupId, $imageId)
    {
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
