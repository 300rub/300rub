<?php

namespace ss\controllers\image;

use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;

/**
 * Updates block
 */
class UpdateBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkData(
            [
                'id'                => [self::TYPE_INT, self::NOT_EMPTY],
                'name'              => [self::TYPE_STRING],
                'type'              => [self::TYPE_INT],
                'autoCropType'      => [self::TYPE_INT],
                'cropWidth'         => [self::TYPE_INT],
                'cropHeight'        => [self::TYPE_INT],
                'cropX'             => [self::TYPE_INT],
                'cropY'             => [self::TYPE_INT],
                'thumbAutoCropType' => [self::TYPE_INT],
                'useAlbums'         => [self::TYPE_BOOL],
                'thumbCropX'        => [self::TYPE_INT],
                'thumbCropY'        => [self::TYPE_INT],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('id'),
            Operation::IMAGE_UPDATE_SETTINGS
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));

        $imageModel = $blockModel
            ->getContentModel(
                false,
                null,
                ImageModel::CLASS_NAME
            );
        $imageModel->set(
            [
                'type'              => $this->get('type'),
                'autoCropType'      => $this->get('autoCropType'),
                'cropWidth'         => $this->get('cropWidth'),
                'cropHeight'        => $this->get('cropHeight'),
                'cropX'             => $this->get('cropX'),
                'cropY'             => $this->get('cropY'),
                'thumbAutoCropType' => $this->get('thumbAutoCropType'),
                'useAlbums'         => $this->get('useAlbums'),
                'thumbCropX'        => $this->get('thumbCropX'),
                'thumbCropY'        => $this->get('thumbCropY'),
            ]
        );
        $imageModel->save();

        $blockModel->set(
            [
                'name' => $this->get('name'),
            ]
        );
        $blockModel->save();

        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                'errors' => $errors
            ];
        }

        $blockModel->setContent();

        return [
            'result' => true,
            'html'   => $blockModel->getHtml(),
            'css'    => $blockModel->getCss(),
            'js'     => $blockModel->getJs(),
        ];
    }
}
