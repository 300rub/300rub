<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
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
                'useAlbums'         => [self::TYPE_BOOL],
                'viewAutoCropType'  => [self::TYPE_INT],
                'viewCropX'         => [self::TYPE_INT],
                'viewCropY'         => [self::TYPE_INT],
                'thumbAutoCropType' => [self::TYPE_INT],
                'thumbCropX'        => [self::TYPE_INT],
                'thumbCropY'        => [self::TYPE_INT],
            ]
        );

        $imageModel = new ImageModel();
        $imageModel->set(
            [
                'type'              => $this->get('type'),
                'useAlbums'         => $this->get('useAlbums'),
                'viewAutoCropType'  => $this->get('autoCropType'),
                'viewCropX'         => $this->get('viewCropX'),
                'viewCropY'         => $this->get('viewCropY'),
                'thumbAutoCropType' => $this->get('thumbAutoCropType'),
                'thumbCropX'        => $this->get('thumbCropX'),
                'thumbCropY'        => $this->get('thumbCropY'),
            ]
        );
        $imageModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => $this->get('name'),
                'language'    => App::getInstance()
                    ->getLanguage()
                    ->getActiveId(),
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
