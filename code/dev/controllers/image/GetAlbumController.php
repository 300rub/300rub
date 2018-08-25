<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
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
     * Seo model
     *
     * @var SeoModel
     */
    private $_seoModel = null;

    /**
     * Name
     *
     * @var string
     */
    private $_name = '';

    /**
     * Alias
     *
     * @var string
     */
    private $_alias = '';

    /**
     * Title
     *
     * @var string
     */
    private $_title = '';

    /**
     * Keywords
     *
     * @var string
     */
    private $_keywords = '';

    /**
     * Description
     *
     * @var string
     */
    private $_description = '';

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

        $this->_setVariables();

        $groupId = (int)$this->get('id');
        $blockId = (int)$this->get('blockId');

        $language = App::getInstance()->getLanguage();

        $titleKey = 'updateAlbum';
        $buttonKey = 'update';
        if ($groupId === 0) {
            $titleKey = 'createAlbum';
            $buttonKey = 'add';
        }

        $aliasValidation = $this
            ->_seoModel
            ->getValidationRulesForField('alias');

        return [
            'blockId' => $blockId,
            'id'      => $groupId,
            'title'   => $language->getMessage('image', $titleKey),
            'forms'   => [
                'name'   => [
                    'name'       => 'name',
                    'label'      => $language->getMessage('common', 'name'),
                    'validation'
                        => $this->_seoModel->getValidationRulesForField('name'),
                    'value'      => $this->_name,
                ],
                'alias'   => [
                    'name'       => 'alias',
                    'label'      => $language->getMessage('common', 'alias'),
                    'validation' => $aliasValidation,
                    'value'      => $this->_alias,
                ],
                'title'   => [
                    'name'       => 'title',
                    'label'      => $language->getMessage('common', 'title'),
                    'validation'
                        => $this->_seoModel->getValidationRulesForField(
                            'title'
                        ),
                    'value'      => $this->_title,
                ],
                'keywords'   => [
                    'name'       => 'keywords',
                    'label'      => $language->getMessage('common', 'keywords'),
                    'validation'
                        => $this->_seoModel->getValidationRulesForField(
                            'keywords'
                        ),
                    'value'      => $this->_keywords,
                ],
                'description'   => [
                    'name'       => 'description',
                    'label'
                        => $language->getMessage('common', 'description'),
                    'validation'
                        => $this->_seoModel->getValidationRulesForField(
                            'description'
                        ),
                    'value'      => $this->_description,
                ],
                'button' => [
                    'label' => $language->getMessage('common', $buttonKey),
                ]
            ]
        ];
    }

    /**
     * Sets variables
     *
     * @return GetAlbumController
     *
     * @throws NotFoundException
     */
    private function _setVariables()
    {
        $groupId = (int)$this->get('id');
        $blockId = (int)$this->get('blockId');

        $this->_seoModel = new SeoModel();
        $this->_name = '';
        $this->_alias = '';
        $this->_title = '';
        $this->_keywords = '';
        $this->_description = '';

        if ($groupId === 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockId,
                Operation::IMAGE_CREATE_ALBUM
            );

            return $this;
        }

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

        $this->_seoModel = $imageGroupModel->get('seoModel');
        $this->_name = $this->_seoModel->get('name');
        $this->_alias = $this->_seoModel->get('alias');
        $this->_title = $this->_seoModel->get('title');
        $this->_keywords = $this->_seoModel->get('keywords');
        $this->_description = $this->_seoModel->get('description');

        return $this;
    }
}
