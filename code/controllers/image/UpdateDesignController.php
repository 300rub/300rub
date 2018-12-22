<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;
use ss\models\user\UserEventModel;

/**
 * Updates block's design
 */
class UpdateDesignController extends AbstractBlockController
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
                'blockId' => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPDATE_DESIGN
        );

        $blockModel = BlockModel::model()->getById($this->get('blockId'));

        $imageModel = $blockModel->getContentModel(
            ImageModel::CLASS_NAME
        );

        $imageModel = $this->_setImageDesign($imageModel);
        $imageModel->save();

        $this->writeBlockDesignChangedEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            $blockModel
        );

        return $this->getSimpleSuccessResult();
    }

    /**
     * Sets image model
     *
     * @param ImageModel|AbstractModel $imageModel Image model
     *
     * @return ImageModel
     *
     * @throws BadRequestException
     */
    private function _setImageDesign($imageModel)
    {
        $imageModel->set(
            [
                'designBlockModel'
                => $this->get('designBlockModel'),
            ]
        );

        if (empty($this->get('designImageZoomModel')) === false) {
            $imageModel->set(
                [
                    'designImageZoomModel'
                    => $this->get('designImageZoomModel'),
                ]
            );

            return $imageModel;
        }

        if (empty($this->get('designImageSliderModel')) === false) {
            $imageModel->set(
                [
                    'designImageSliderModel'
                    => $this->get('designImageSliderModel'),
                ]
            );

            return $imageModel;
        }

        if (empty($this->get('designImageSimpleModel')) === false) {
            $imageModel->set(
                [
                    'designImageSimpleModel'
                    => $this->get('designImageSimpleModel'),
                ]
            );

            return $imageModel;
        }

        throw new BadRequestException(
            'Unable to find find designImageZoomModel or ' .
            'designImageSliderModel or designImageSimpleModel ' .
            'in request to update design'
        );
    }
}
