<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\components\ValueGenerator;
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

        $language = App::web()->getLanguage();

        return [
            'id'          => $this->_blockId,
            'title'       => $language->getMessage('image', $titleKey),
            'description' => $language->getMessage('image', $descriptionKey),
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
                    'list'  => ValueGenerator::factory(
                        ValueGenerator::ORDERED_ARRAY,
                        $this->_imageModel->getTypeList()
                    )->generate()
                ],
                'autoCropType'      => [
                    'label' => $language->getMessage('image', 'autoCropType'),
                    'value' => $this->_imageModel->get('autoCropType'),
                    'name'  => 'autoCropType',
                    'list'  => $this->_imageModel->getAutoCropTypeList()
                ],
                'cropWidth'         => [
                    'name'  => 'cropWidth',
                    'label' => $language->getMessage('image', 'cropWidth'),
                    'value' => $this->_imageModel->get('cropWidth'),
                ],
                'cropHeight'        => [
                    'name'  => 'cropHeight',
                    'label' => $language->getMessage('image', 'cropHeight'),
                    'value' => $this->_imageModel->get('cropHeight'),
                ],
                'cropX'             => [
                    'name'  => 'cropX',
                    'label' => $language->getMessage('image', 'cropX'),
                    'value' => $this->_imageModel->get('cropX'),
                ],
                'cropY'             => [
                    'name'  => 'cropY',
                    'label' => $language->getMessage('image', 'cropY'),
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
                    'label' => $language->getMessage('image', 'thumbCropX'),
                    'value' => $this->_imageModel->get('thumbCropX'),
                ],
                'thumbCropY'        => [
                    'name'  => 'thumbCropY',
                    'label' => $language->getMessage('image', 'thumbCropY'),
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
