<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
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
                'useAlbums'         => [self::TYPE_BOOL],
                'viewAutoCropType'  => [self::TYPE_INT],
                'viewCropX'         => [self::TYPE_INT],
                'viewCropY'         => [self::TYPE_INT],
                'thumbAutoCropType' => [self::TYPE_INT],
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
                ImageModel::CLASS_NAME
            );
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

        return $this->getSimpleSuccessResult();
    }
}
