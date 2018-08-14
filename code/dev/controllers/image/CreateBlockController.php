<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;

/**
 * Adds block
 */
class CreateBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            Operation::ALL,
            Operation::IMAGE_ADD
        );

        $this->checkData(
            [
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

        $imageModel = new ImageModel();
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

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => $this->get('name'),
                'language'    => App::getInstance()->getLanguage()->getActiveId(),
                'contentType' => BlockModel::TYPE_IMAGE,
                'contentId'   => $imageModel->getId(),
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

        return $this->getSimpleSuccessResult();
    }
}
