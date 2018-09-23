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
        $buttonLabelKey = 'update';
        if ($this->_blockId === 0) {
            $titleKey = 'addBlockTitle';
            $descriptionKey = 'addBlockDescription';
            $buttonLabelKey = 'add';
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
            'labels'      => [
                'duplicate'         => $language->getMessage('common', 'duplicate'),
                'delete'            => $language->getMessage('common', 'delete'),
                'deleteConfirmText' => $language->getMessage('image', 'deleteConfirmText'),
                'no'                => $language->getMessage('common', 'no'),
                'hasAutoCrop'       => $language->getMessage('image', 'hasAutoCrop'),
                'configureCrop'     => $language->getMessage('image', 'configureCrop'),
                'cropProportions'   => $language->getMessage('image', 'cropProportions'),
            ],
            'forms'       => [
                'name'              => [
                    'name'       => 'name',
                    'label'      => $language->getMessage('common', 'name'),
                    'validation'
                        => $this->_blockModel->getValidationRulesForField(
                            'name'
                        ),
                    'value'      => $this->_blockModel->get('name'),
                ],
                'type'              => [
                    'label' => $language->getMessage('common', 'type'),
                    'value' => $this->_imageModel->get('type'),
                    'name'  => 'type',
                    'list'  => $typeList
                ],
                'autoCropType'      => [
                    'label' => $language->getMessage('image', 'autoCropType'),
                    'value' => $this->_imageModel->get('autoCropType'),
                    'name'  => 'autoCropType',
                    'list'  => $this->_imageModel->getAutoCropTypeList()
                ],
                'cropX'             => [
                    'name'  => 'cropX',
                    'value' => $this->_imageModel->get('cropX'),
                ],
                'cropY'             => [
                    'name'  => 'cropY',
                    'value' => $this->_imageModel->get('cropY'),
                ],
                'thumbAutoCropType' => [
                    'label'
                        => $language->getMessage('image', 'thumbAutoCropType'),
                    'value' => $this->_imageModel->get('thumbAutoCropType'),
                    'name'  => 'thumbAutoCropType',
                    'list'  => $this->_imageModel->getAutoCropTypeList()
                ],
                'useAlbums'         => [
                    'name'  => 'useAlbums',
                    'label' => $language->getMessage('image', 'useAlbums'),
                    'value' => $this->_imageModel->get('useAlbums'),
                ],
                'thumbCropX'        => [
                    'name'  => 'thumbCropX',
                    'value' => $this->_imageModel->get('thumbCropX'),
                ],
                'thumbCropY'        => [
                    'name'  => 'thumbCropY',
                    'value' => $this->_imageModel->get('thumbCropY'),
                ],
                'button'            => [
                    'label' => $language->getMessage('common', $buttonLabelKey),
                ]
            ]
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
