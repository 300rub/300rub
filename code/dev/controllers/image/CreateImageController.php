<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Adds block
 */
class CreateImageController extends AbstractController
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
                'blockId' => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPLOAD
        );

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(
            [
                'imageGroupId' => $this->_getImageGroupId(),
            ]
        );

        $result = $imageInstanceModel->upload();

        return [
            'id'   => $result['id'],
            'name' => $result['name'],
            'url'  => $result['thumbUrl'],
        ];
    }

    /**
     * Gets group ID
     *
     * @return int
     */
    private function _getImageGroupId()
    {
        $imageGroupId = (int)$this->get('imageGroupId');

        if ($imageGroupId > 0) {
            return $imageGroupId;
        }

        $blockModel = BlockModel::model()->getById($this->get('blockId'));

        $imageGroupModel = ImageGroupModel::model()
            ->byImageId($blockModel->get('contentId'))
            ->find();

        if ($imageGroupModel !== null) {
            return $imageGroupModel->getId();
        }

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                'imageId' => $blockModel->get('contentId'),
                'seoModel' => [
                    'name'  => App::getInstance()
                        ->getLanguage()
                        ->getMessage('common', 'default'),
                    'alias' => 'default'
                ]
            ]
        );
        $imageGroupModel->save();

        return $imageGroupModel->getId();
    }
}
