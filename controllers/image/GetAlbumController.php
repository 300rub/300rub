<?php

namespace testS\controllers\image;

use testS\application\App;
use testS\application\components\Operation;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\image\ImageGroupModel;
use testS\models\blocks\image\ImageModel;

/**
 * Gets block
 */
class GetAlbumController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function run()
    {
        $this->checkData(
            [
                'blockId' => [self::NOT_EMPTY],
            ]
        );

        $groupId = (int)$this->get('id');
        $blockId = (int)$this->get('blockId');

        $imageGroupModel = new ImageGroupModel();
        $name = '';

        if ($groupId === 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockId,
                Operation::IMAGE_CREATE_ALBUM
            );
        }

        if ($groupId > 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockId,
                Operation::IMAGE_UPDATE_ALBUM
            );

            $blockModel = BlockModel::model()->getById($this->get('blockId'));
            $imageModel = $blockModel->getContentModel(
                false,
                null,
                ImageModel::CLASS_NAME
            );
            $imageGroupModel = ImageGroupModel::model()
                ->byImageId($imageModel->getId())
                ->byId($groupId)
                ->find();

            if ($imageGroupModel === null) {
                throw new NotFoundException(
                    'Unable to find ImageGroupModel by ID: {id} and ' .
                    'blockId: {blockId} and imageId: {imageId}',
                    [
                        'id'      => $groupId,
                        'blockId' => $blockModel->get(),
                        'imageId' => $imageModel->getId(),
                    ]
                );
            }

            $name = $imageGroupModel->get('name');
        }

        $language = App::web()->getLanguage();

        $titleKey = 'updateAlbum';
        $buttonKey = 'update';
        if ($groupId === 0) {
            $titleKey = 'createAlbum';
            $buttonKey = 'add';
        }

        return [
            'blockId' => $blockId,
            'id'      => $groupId,
            'title'   => $language->getMessage('image', $titleKey),
            'forms'   => [
                'name'   => [
                    'name'       => 'name',
                    'label'      => $language->getMessage('common', 'name'),
                    'validation'
                        => $imageGroupModel->getValidationRulesForField('name'),
                    'value'      => $name,
                ],
                'button' => [
                    'label' => $language->getMessage('common', $buttonKey),
                ]
            ]
        ];
    }
}
