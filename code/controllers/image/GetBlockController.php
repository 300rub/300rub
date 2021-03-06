<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;

/**
 * Gets block
 */
class GetBlockController extends AbstractController
{

    /**
     * BlockModel
     *
     * @var BlockModel
     */
    private $_blockModel = null;

    /**
     * ImageModel
     *
     * @var ImageModel
     */
    private $_imageModel = null;

    /**
     * Block ID
     *
     * @var integer
     */
    private $_blockId = 0;

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->_setValues();

        $titleKey = 'editBlockTitle';
        $descriptionKey = 'editBlockDescription';
        if ($this->_blockId === 0) {
            $titleKey = 'addBlockTitle';
            $descriptionKey = 'addBlockDescription';
        }

        $language = App::getInstance()->getLanguage();

        $typeList = App::getInstance()
            ->getValueGenerator()
            ->getValue(
                ValueGenerator::ORDERED_ARRAY,
                $this->_imageModel->getTypeList()
            );

        return [
            'id'          => $this->_blockId,
            'title'       => $language->getMessage('image', $titleKey),
            'description' => $language->getMessage('image', $descriptionKey),
            'labels'      => $this->_getLabels(),
            'forms'       => [
                'name'              => [
                    'name'  => 'name',
                    'label' => $language->getMessage('common', 'name'),
                    'validation'
                            => $this->_blockModel->getValidationRulesForField(
                        'name'
                    ),
                    'value' => $this->_blockModel->get('name'),
                ],
                'type'              => [
                    'label' => $language->getMessage('common', 'type'),
                    'value' => $this->_imageModel->get('type'),
                    'name'  => 'type',
                    'list'  => $typeList
                ],
                'useAlbums'         => [
                    'name'  => 'useAlbums',
                    'label' => $language->getMessage('image', 'useAlbums'),
                    'value' => $this->_imageModel->get('useAlbums'),
                ],
                'viewCropX'         => [
                    'name'  => 'viewCropX',
                    'value' => $this->_imageModel->get('viewCropX'),
                ],
                'viewCropY'         => [
                    'name'  => 'viewCropY',
                    'value' => $this->_imageModel->get('viewCropY'),
                ],
                'viewAutoCropType'  => [
                    'label' => $language->getMessage('image', 'viewAutoCropType'),
                    'value' => $this->_imageModel->get('viewAutoCropType'),
                    'name'  => 'viewAutoCropType',
                    'list'  => $this->_imageModel->getAutoCropTypeList()
                ],
                'thumbCropX'        => [
                    'name'  => 'thumbCropX',
                    'value' => $this->_imageModel->get('thumbCropX'),
                ],
                'thumbCropY'        => [
                    'name'  => 'thumbCropY',
                    'value' => $this->_imageModel->get('thumbCropY'),
                ],
                'thumbAutoCropType' => [
                    'label'
                        => $language->getMessage('image', 'thumbAutoCropType'),
                    'value' => $this->_imageModel->get('thumbAutoCropType'),
                    'name'  => 'thumbAutoCropType',
                    'list'  => $this->_imageModel->getAutoCropTypeList()
                ],
            ]
        ];
    }

    /**
     * Gets labels
     *
     * @return array
     */
    private function _getLabels()
    {
        $language = App::getInstance()->getLanguage();

        $buttonLabelKey = 'update';
        if ($this->_blockId === 0) {
            $buttonLabelKey = 'add';
        }

        return [
            'duplicate'
                => $language->getMessage('common', 'duplicate'),
            'delete'
                => $language->getMessage('common', 'delete'),
            'deleteConfirmText'
                => $language->getMessage('image', 'deleteConfirmText'),
            'no'
                => $language->getMessage('common', 'no'),
            'configureCrop'
                => $language->getMessage('image', 'configureCrop'),
            'cropProportions'
                => $language->getMessage('image', 'cropProportions'),
            'hasAutoCrop'
                => $language->getMessage('image', 'hasAutoCrop'),
            'configureThumbCrop'
                => $language->getMessage('image', 'configureThumbCrop'),
            'thumbCropProportions'
                => $language->getMessage('image', 'thumbCropProportions'),
            'hasThumbAutoCrop'
                => $language->getMessage('image', 'hasThumbAutoCrop'),
            'button'
                => $language->getMessage('common', $buttonLabelKey),
        ];
    }

    /**
     * Sets values
     *
     * @return void
     */
    private function _setValues()
    {
        $this->_blockModel = new BlockModel();
        $this->_imageModel = new ImageModel();

        $this->_blockId = (int)$this->get('id');
        if ($this->_blockId === 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_IMAGE,
                Operation::ALL,
                Operation::IMAGE_ADD
            );
        }

        if ($this->_blockId > 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_IMAGE,
                $this->_blockId,
                Operation::IMAGE_UPDATE_SETTINGS
            );

            $this->_blockModel = $this->_blockModel->getById($this->_blockId);
            $this->_imageModel = $this->_blockModel->getContentModel(
                ImageModel::CLASS_NAME
            );
        }
    }
}
