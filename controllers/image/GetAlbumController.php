<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageModel;
use ss\models\sections\SeoModel;

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

        $seoModel = new SeoModel();
        $name = '';
        $url = '';
        $title = '';
        $keywords = '';
        $description = '';

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

            $seoModel = $imageGroupModel->get('seoModel');
            $name = $seoModel->get('name');
            $url = $seoModel->get('url');
            $title = $seoModel->get('title');
            $keywords = $seoModel->get('keywords');
            $description = $seoModel->get('description');
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
                        => $seoModel->getValidationRulesForField('name'),
                    'value'      => $name,
                ],
                'url'   => [
                    'name'       => 'url',
                    'label'      => $language->getMessage('common', 'url'),
                    'validation'
                    => $seoModel->getValidationRulesForField('url'),
                    'value'      => $url,
                ],
                'title'   => [
                    'name'       => 'title',
                    'label'      => $language->getMessage('common', 'title'),
                    'validation'
                    => $seoModel->getValidationRulesForField('title'),
                    'value'      => $title,
                ],
                'keywords'   => [
                    'name'       => 'keywords',
                    'label'      => $language->getMessage('common', 'keywords'),
                    'validation'
                    => $seoModel->getValidationRulesForField('keywords'),
                    'value'      => $keywords,
                ],
                'description'   => [
                    'name'       => 'description',
                    'label'      => $language->getMessage('common', 'description'),
                    'validation'
                    => $seoModel->getValidationRulesForField('description'),
                    'value'      => $description,
                ],
                'button' => [
                    'label' => $language->getMessage('common', $buttonKey),
                ]
            ]
        ];
    }
}
